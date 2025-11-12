<?php
// Database configuration
$host = "localhost";       // Database host (use 127.0.0.1 or localhost)
$user = "root";            // MySQL username (default: root)
$pass = "";                // MySQL password (leave empty if using XAMPP default)
$dbname = "pdf_api_db";    // Database name

// Create database connection
$conn = new mysqli($host, $user, $pass, $dbname);

// Check connection
if ($conn->connect_error) {
    die(json_encode([
        "success" => false,
        "message" => "Database connection failed: " . $conn->connect_error
    ]));
}

// Optional: set UTF-8 charset
$conn->set_charset("utf8");

// If you want to test connection manually, uncomment below:
// echo json_encode(["success" => true, "message" => "Database connected successfully."]);
?>
