<?php

class UserService
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    // Регистрация нового пользователя
    public function register($username, $password, $email)
    {
        $password = md5($password);
        $token = bin2hex(openssl_random_pseudo_bytes(20));

        // Проверка наличия почтового адреса в базе данных
        $email_check_sql = "SELECT * FROM users WHERE email = '$email'";
        $email_check_result = $this->conn->query($email_check_sql);

        if ($email_check_result->num_rows > 0) {
            return [
                'message' => "Ошибка: Электронная почта уже существует"
            ];
        }

        // Добавление нового пользователя в базу данных
        $sql = "INSERT INTO users (username, password, email, token) VALUES ('$username','$password','$email','$token')";

        if ($this->conn->query($sql) === TRUE) {
            return json_encode($sql);
        } else {
            return [
                'error' => "Ошибка: " . $sql . "<br>" . $this->conn->error
            ];
        }
    }

    // Авторизация пользователя
    public function login($email, $password)
    {
        $sql = "SELECT * FROM users WHERE email = '$email'";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        $result = $stmt->get_result();


        if ($result->num_rows == 1) {
            $user_data = $result->fetch_assoc();

            if (md5($password) === $user_data['password']) {

                // Начало сеанса
                session_start();
                $_SESSION['login'] = true;
                $_SESSION['user'] = isset($user_data['username']) ? $user_data['username'] : '';
                $_SESSION['uid'] = isset($user_data['ID']) ? $user_data['ID'] : '';

                $stmt->close();
                $this->conn->close();

                echo json_encode([
                    'token' => $user_data['token']
                ]);

                exit;

            } else {
                http_response_code(401);

                echo json_encode([
                    'message' => "Неверное имя пользователя или пароль"
                ]);
            }
        }

        $stmt->close();
        $this->conn->close();
    }

    // Выход пользователя
    public function logout(){

        session_start();

        //todo отменить токен
        http_response_code(200);

        $_SESSION = array();

        session_destroy();

        exit;
    }

    // Получение авторизованного пользователя по токену
    public function getAuthUser($token){
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE token = ?");
        $stmt->bind_param("s", $token);

        // Выполнение запроса
        $stmt->execute();

        // Получение результата
        $result = $stmt->get_result();

        // Проверка наличия пользователя с токеном
        if ($result->num_rows > 0) {
            // Пользователь найден, возвращаем данные о пользователе
            return json_encode($result->fetch_assoc());
        } else {
            // Пользователь не найден
            return null;
        }
    }
}
