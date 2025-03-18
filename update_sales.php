<?php
require 'db_connect.php';

// Get the JSON data from the request
$data = json_decode(file_get_contents('php://input'), true);

if (!$data) {
    echo json_encode(['success' => false, 'message' => 'Invalid JSON data']);
    exit();
}

$customer_name = $data['customer_name'] ?? null;
$customer_email = $data['customer_email'] ?? null;
$customer_phone = $data['customer_phone'] ?? null;
$payment_method = $data['payment_method'] ?? null;
$final_amount = $data['final_amount'] ?? null;
$items = $data['items'] ?? [];

if (!$customer_email) {
    echo json_encode(['success' => false, 'message' => 'Customer email is required']);
    exit();
}

// Check if the customer already exists
$sql = "SELECT id FROM Customers WHERE email = '$customer_email'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Customer exists, fetch the customer ID
    $row = $result->fetch_assoc();
    $customer_id = $row['id'];
} else {
    // Customer does not exist, return a response indicating that the customer needs to be added
    echo json_encode(['success' => false, 'message' => 'Customer does not exist. Please add the customer first.']);
    $conn->close();
    exit();
}

// Insert each item into the sales table and update stock
foreach ($items as $item) {
    $product_id = $item['product_id'];
    $quantity = $item['quantity'];
    $unit_price = $item['price'];
    $discount = $item['discount'];
    $total_price = $item['total'];
    $final_amount_item = $item['final_amount'];
    $status = 'completed'; // Assuming the status is completed for now
    $purchase_date = date('Y-m-d H:i:s');

    // Insert into Sales table
    $sql = "INSERT INTO Sales (product_id, customer_id, quantity, unit_price, discount, total_price, final_amount, payment_method, status, purchase_date) 
            VALUES ('$product_id', '$customer_id', '$quantity', '$unit_price', '$discount', '$total_price', '$final_amount_item', '$payment_method', '$status', '$purchase_date')";

    if ($conn->query($sql) !== TRUE) {
        echo json_encode(['success' => false, 'message' => 'Error: ' . $sql . '<br>' . $conn->error]);
        $conn->close();
        exit();
    }

    // Update stock in Products table
    $sql = "UPDATE Stocks SET quantity = quantity - $quantity WHERE id = '$product_id'";
    if ($conn->query($sql) !== TRUE) {
        echo json_encode(['success' => false, 'message' => 'Error updating stock: ' . $sql . '<br>' . $conn->error]);
        $conn->close();
        exit();
    }
}

echo json_encode(['success' => true]);
$conn->close();
?>