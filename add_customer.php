<?php
require 'db_connect.php';

header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data = json_decode(file_get_contents('php://input'), true);
    $name = $data['customer_name'];
    $phone = $data['customer_phone'];
    $email = $data['customer_email'];

    $sql = "INSERT INTO Customers (name, phone, email) VALUES ('$name', '$phone', '$email')";
    
    if ($conn->query($sql) === TRUE) {
        echo json_encode(['success' => true, 'message' => 'Customer added successfully.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error: ' . $conn->error]);
    }
    $conn->close();
    exit();
}
?>