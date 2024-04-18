<?php


include('config.php');
global $servername, $username, $DBpassword, $dbname;

// Check if it's a preflight request
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

// Function to retrieve user by token
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

// Usage example
$url = $_SERVER['REQUEST_URI'];

// Split the URL path into segments
$segments = explode('/', $url);

// Get the last segment (which should be the token)
$token = end($segments);

if (!empty($token)) {
    $user = getUserByToken($token);
    if ($user) {
        // User found, do something with user data
        echo json_encode($user);
    } else {
        // User not found
        echo "User not found";
    }
} else {
    echo "Token not provided";
}

// Close connection
$conn->close();