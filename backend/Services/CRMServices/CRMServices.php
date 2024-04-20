<?php

class CRMServices
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    // Получение пользователя по токену
    public function getUserByToken($token)
    {

        $stmt = $this->conn->prepare("SELECT * FROM users WHERE token = ?");
        $stmt->bind_param("s", $token);

        $stmt->execute();

        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            return json_encode($result->fetch_assoc());
        } else {
            return null;
        }
    }

    // Получение заказов пользователя
    public function getUserOrders($token)
    {

        $user_id = json_decode($this->getUserByToken($token), true)['ID'];

        $sql = "SELECT * FROM orders where user_id = '$user_id'";

        $result = $this->conn->query($sql);

        $orders = array();

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $orders[] = $row;
            }
        } else {
            echo "Заказы не найдены";
        }

        $this->conn->close();

        header('Content-Type: application/json');
        echo json_encode($orders);
    }

    // Получение заказа по ID
    public function getOrder($id)
    {
        if ($id) {

            $sql = "SELECT * FROM orders WHERE ID = '$id'";

            $result = $this->conn->query($sql);

            if ($result && $result->num_rows > 0) {
                $order = $result->fetch_assoc();

                header('Content-Type: application/json');
                echo json_encode($order);
            } else {
                http_response_code(404);
                echo json_encode(array("message" => "Заказ не найден."));
            }
        } else {
            http_response_code(400);
            echo json_encode(array("message" => "ID заказа не предоставлен."));
        }

        $this->conn->close();

    }

    // Обновление информации о заказе
    public function updateOrder($detail, $status, $order_id)
    {

        $sql = "UPDATE orders SET detail=?, status=? WHERE ID=?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ssi", $detail, $status, $order_id);

        if ($stmt->execute()) {
            http_response_code(200);
            exit();
        } else {
            echo "Ошибка: " . $stmt->error;
        }

        $this->conn->close();
    }

    // Удаление заказа
    public function deleteOrder($order_id)
    {

        $sql = "DELETE FROM orders WHERE ID='$order_id'";

        if ($this->conn->query($sql) === TRUE) {
            http_response_code(200);
            exit();
        } else {
            echo "Ошибка: " . $sql . "<br>" . $this->conn->error;
        }

        $this->conn->close();
    }

    // Создание нового заказа
    public function createOrder($detail, $status, $token)
    {
        $user_id = json_decode($this->getUserByToken($token), true)['ID'];


        $sql = "INSERT INTO orders (detail, status, user_id) VALUES ('$detail','$status','$user_id')";

        if ($this->conn->query($sql) === TRUE) {

            http_response_code(200);
            exit();

        } else {
            echo "Ошибка: " . $sql . "<br>" . $this->conn->error;
        }

        $this->conn->close();
    }
}
