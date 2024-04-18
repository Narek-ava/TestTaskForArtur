<?php

include('config.php');
global $servername, $username, $DBpassword, $dbname;


if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    http_response_code(200);
    exit();
}
// Create connection
$conn = new mysqli($servername, $username, $DBpassword, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the order ID is provided via GET parameter
if (isset($_GET['id'])) {
    // Sanitize the input to prevent SQL injection
    $order_id = mysqli_real_escape_string($conn, $_GET['id']);

    // Prepare SQL query to fetch order details
    $sql = "SELECT * FROM orders WHERE ID = '$order_id'";

    // Execute the query
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        // Fetch order details as an associative array
        $order = $result->fetch_assoc();

        // Return order details as JSON response
        header('Content-Type: application/json');
        echo json_encode($order);
    } else {
        // Order not found
        http_response_code(404);
        echo json_encode(array("message" => "Order not found."));
    }
} else {
    // No order ID provided
    http_response_code(400);
    echo json_encode(array("message" => "Order ID not provided."));
}

// Close database connection
$conn->close();
