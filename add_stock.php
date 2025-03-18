<?php
include 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $productName = $_POST['product_name'];
    $quantity = $_POST['quantity'];
    $purchasePrice = $_POST['purchase_price'];
    $supplierName = $_POST['supplier_name'];
    $purchaseDate = $_POST['purchase_date'];
    $expiryDate = $_POST['expiry_date'];

    // Fetch Product ID based on Product Name
    $productQuery = "SELECT id FROM Products WHERE name = ?";
    $stmt = $conn->prepare($productQuery);
    $stmt->bind_param("s", $productName);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($row = $result->fetch_assoc()) {
        $productID = $row['id']; // Product exists, use its ID
    } else {
        // Insert new product if it doesn't exist
        $insertProductQuery = "INSERT INTO Products (name) VALUES (?)";
        $stmt = $conn->prepare($insertProductQuery);
        $stmt->bind_param("s", $productName);
        $stmt->execute();
        $productID = $stmt->insert_id; // Get the newly inserted Product ID
    }

    // Check if the product is already in stock with the same supplier and price
    $stockQuery = "SELECT id, quantity FROM Stocks WHERE product_id = ? AND purchase_price = ? AND supplier_name = ?";
    $stmt = $conn->prepare($stockQuery);
    $stmt->bind_param("ids", $productID, $purchasePrice, $supplierName);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        // Product is already in stock, update quantity
        $newQuantity = $row['quantity'] + $quantity;
        $updateStockQuery = "UPDATE Stocks SET quantity = ?, purchase_date = ?, expiry_date = ?, Added_date = NOW() WHERE id = ?";
        $stmt = $conn->prepare($updateStockQuery);
        $stmt->bind_param("issi", $newQuantity, $purchaseDate, $expiryDate, $row['id']);
        $stmt->execute();
    } else {
        // Product is not in stock, insert a new entry
        $insertStockQuery = "INSERT INTO Stocks (product_id, quantity, purchase_price, supplier_name, purchase_date, expiry_date, Added_date) VALUES (?, ?, ?, ?, ?, ?, NOW())";
        $stmt = $conn->prepare($insertStockQuery);
        $stmt->bind_param("iidsss", $productID, $quantity, $purchasePrice, $supplierName, $purchaseDate, $expiryDate);
        $stmt->execute();
    }

    echo "Stock added successfully!";
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Stock</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 20px;
            text-align: center;
        }
        h2 {
            color: #333;
        }
        form {
            background: white;
            padding: 20px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            display: inline-block;
            text-align: left;
        }
        label {
            display: block;
            margin: 10px 0 5px;
        }
        input {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        button {
            padding: 10px 15px;
            margin: 10px 0;
            border: none;
            cursor: pointer;
            border-radius: 5px;
            font-size: 14px;
            background: #28a745;
            color: white;
        }
        button:hover {
            background: #218838;
        }
    </style>
</head>
<body>

    <h2>Add Stock</h2>

    <form method="post">
        <label>Product Name:</label>
        <input type="text" name="product_name" required>
        
        <label>Quantity:</label>
        <input type="number" name="quantity" required>
        
        <label>Purchase Price:</label>
        <input type="text" name="purchase_price" required>
        
        <label>Supplier Name:</label>
        <input type="text" name="supplier_name" required>
        
        <label>Purchase Date:</label>
        <input type="date" name="purchase_date" required>
        
        <label>Expiry Date:</label>
        <input type="date" name="expiry_date">
        
        <button type="submit">Add Stock</button>
    </form>

</body>
</html>













