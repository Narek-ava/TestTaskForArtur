<?php

include('config.php');
global $servername, $username, $DBpassword, $dbname;


$conn = new mysqli($servername, $username, $DBpassword, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$request = json_decode(file_get_contents('php://input'), true);
$email = $request['email'];
$password = $request['password'];
$sql = "SELECT * FROM users WHERE email = '$email'";

$stmt = $conn->prepare($sql);
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
        $conn->close();

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
$conn->close();
