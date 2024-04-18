<?php
session_start();
include('config.php');
global $servername, $username, $DBpassword, $dbname;


// Check if it's a preflight request
    http_response_code(200);

// Unset all of the session variables
$_SESSION = array();

// Destroy the session
session_destroy();

// Redirect to login page or any other page after logout
//header("Location: login.php");
exit;