<?php
$servername = "localhost";  
$username = "root";  // Default XAMPP username
$password = "";      // Default XAMPP password (leave empty)
$database = "billing_system";  

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>