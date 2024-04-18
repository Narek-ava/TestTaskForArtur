<?php
include('config.php');
global $servername, $username, $DBpassword, $dbname;
$conn = new mysqli($servername, $username, $DBpassword, $dbname);

function getUserByToken($token) {
    global $conn;

    // Prepare SQL statement
    $stmt = $conn->prepare("SELECT * FROM users WHERE token = ?");
    $stmt->bind_param("s", $token);

    // Execute query
    $stmt->execute();

    // Get result
    $result = $stmt->get_result();

    // Check if user with token exists
    if ($result->num_rows > 0) {
        // User found, return user data
        return $result->fetch_assoc();
    } else {
        // User not found
        return null;
    }
}
$url = $_SERVER['REQUEST_URI'];

// Split the URL path into segments
$segments = explode('/', $url);

// Get the last segment (which should be the token)
$token = end($segments);

if (!empty($token)) {
    $user_id = getUserByToken($token)['ID'];
}
    if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
        http_response_code(200);
        exit();
    }
$conn = new mysqli($servername, $username, $DBpassword, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get result
$sql = "SELECT * FROM orders where user_id = '$user_id'";

$result = $conn->query($sql);

$orders = array();

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $orders[] = $row;
    }
} else {
    echo "No orders found";
}

$conn->close();

header('Content-Type: application/json');
echo json_encode($orders);

