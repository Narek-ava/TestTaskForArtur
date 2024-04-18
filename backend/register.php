<?php

include('config.php');
global $servername, $username, $DBpassword, $dbname;

$conn = new mysqli($servername, $username, $DBpassword, $dbname);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$request = json_decode(file_get_contents('php://input'), true);
$username = $request['name'];
$password = md5($request['password']);
$email = $request['email'];
$token = bin2hex(openssl_random_pseudo_bytes(20));

$email_check_sql = "SELECT * FROM users WHERE email = '$email'";
$email_check_result = $conn->query($email_check_sql);

if ($email_check_result->num_rows > 0) {
    echo json_encode([
        'message' => "Error: Email already exists"
    ]);
    http_response_code(400);

    $conn->close();
    exit();
}

$sql = "INSERT INTO users (username, password, email,token) VALUES ('$username','$password','$email','$token')";

if ($conn->query($sql) === TRUE) {

    echo json_encode([
        'token' => $token
    ]);

} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
