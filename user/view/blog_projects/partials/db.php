<?php
$host = 'localhost';
$user = 'root';
$pass = '';
$db   = 'blog_db';

// Create connection
$conn = new mysqli($host, $user, $pass, $db);

// Check connection
if ($conn->connect_error) {
    die(" Database connection failed: " . $conn->connect_error);
}

// Set proper charset
if (!$conn->set_charset("utf8mb4")) {
    printf("Error loading character set utf8mb4: %s\n", $conn->error);
}
?>
