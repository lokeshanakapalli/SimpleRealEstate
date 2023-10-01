<?php
// Replace these with your actual database credentials
$hostname = "localhost";
$username = "root";
$password = "";
$database = "sreeja";

// Create a database connection
$conn = new mysqli($hostname, $username, $password, $database);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$conn->set_charset("utf8");

