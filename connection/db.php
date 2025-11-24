<?php
$servername = "localhost";
$username   = "root";
$password   = "";  
$database   = "graventocms";

// Create connection using MySQLi 
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Database Connection Failed: " . $conn->connect_error);
}

?>
