<?php

include('config.php');
global $servername, $username, $DBpassword, $dbname;


if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    http_response_code(200);
    exit();
}

$conn = new mysqli($servername, $username, $DBpassword, $dbname);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$request = json_decode(file_get_contents('php://input'), true);
$customer = $request['customer'];
$detail = $request['detail'];
$status = $request['status'];
$user_id = $request['user_id'];

$sql = "INSERT INTO orders (detail, status, user_id) VALUES ('$detail','$status','$user_id')";

if ($conn->query($sql) === TRUE) {

    http_response_code(200);
    exit();

} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
