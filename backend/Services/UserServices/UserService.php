<?php

class UserService
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function register($username, $password, $email)
    {
        $password = md5($password);
        $token = bin2hex(openssl_random_pseudo_bytes(20));

        $email_check_sql = "SELECT * FROM users WHERE email = '$email'";
        $email_check_result = $this->conn->query($email_check_sql);

        if ($email_check_result->num_rows > 0) {
            return [
                'message' => "Error: Email already exists"
            ];
        }

        $sql = "INSERT INTO users (username, password, email, token) VALUES ('$username','$password','$email','$token')";

        if ($this->conn->query($sql) === TRUE) {
            return json_encode($sql);
        } else {
            return [
                'error' => "Error: " . $sql . "<br>" . $this->conn->error
            ];
        }
    }

    public function login($email, $password)
    {
        $sql = "SELECT * FROM users WHERE email = '$email'";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        $result = $stmt->get_result();


        if ($result->num_rows == 1) {
            $user_data = $result->fetch_assoc();

            if (md5($password) === $user_data['password']) {

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
                    'message' => "Invalid username or password"
                ]);
            }
        }

        $stmt->close();
        $this->conn->close();
    }
    public function logout(){

        session_start();

         //todo revoke token
        http_response_code(200);

        $_SESSION = array();

        session_destroy();

        exit;
    }

    public function getAuthUser($token){
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE token = ?");
        $stmt->bind_param("s", $token);

        // Execute query
        $stmt->execute();

        // Get result
        $result = $stmt->get_result();

        // Check if user with token exists
        if ($result->num_rows > 0) {
            // UserService found, return user data
            return json_encode($result->fetch_assoc());
        } else {
            // UserService not found
            return null;
        }
    }
}
