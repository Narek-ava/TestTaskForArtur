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

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $request =   json_decode(file_get_contents("php://input"), true);
    $order_id = $request['order_id'];
    $sql = "DELETE FROM orders WHERE ID='$order_id'";

    if ($conn->query($sql) === TRUE) {
        http_response_code(200);
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
