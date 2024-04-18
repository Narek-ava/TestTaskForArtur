<?php
include('config.php');
global $servername, $username, $DBpassword, $dbname;

$conn = new mysqli($servername, $username, $DBpassword, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $request = json_decode(file_get_contents("php://input"), true);
    $order_id = $request['ID']; // Change 'id' to 'ID'
    $detail = $request['detail'];
    $status = $request['status'];


    $sql = "UPDATE orders SET detail=?, status=? WHERE ID=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssi", $detail, $status, $order_id);

    if ($stmt->execute()) {
        http_response_code(200);
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }
}

$conn->close();
