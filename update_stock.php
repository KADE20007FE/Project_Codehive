
<?php
include 'db_connect.php'; // Ensure this file connects to the database

if (isset($_GET['id'])) {
    $stock_id = $_GET['id'];

    // Fetch stock details
    $query = "SELECT * FROM Stocks WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $stock_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $stock = $result->fetch_assoc();
}

// Update stock details
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $quantity = $_POST['quantity'];
    $purchase_price = $_POST['purchase_price'];
    $supplier_name = $_POST['supplier_name'];
    $purchase_date = $_POST['purchase_date'];
    $expiry_date = $_POST['expiry_date'];

    $update_query = "UPDATE Stocks SET quantity = ?, purchase_price = ?, supplier_name = ?, purchase_date = ?, expiry_date = ? WHERE id = ?";
    $stmt = $conn->prepare($update_query);
    $stmt->bind_param("idsssi", $quantity, $purchase_price, $supplier_name, $purchase_date, $expiry_date, $stock_id);

    if ($stmt->execute()) {
        echo "Stock updated successfully!";
        header("Location: stock.php"); // Redirect back to stock list
        exit();
    } else {
        echo "Error updating stock: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Stock</title>
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
            background: #007bff;
            color: white;
        }
        button:hover {
            background: #0056b3;
        }
    </style>
</head>
<body>

    <h2>Update Stock</h2>

    <form method="POST">
        <input type="hidden" name="id" value="<?php echo $stock['id']; ?>">
        
        <label>Quantity:</label>
        <input type="number" name="quantity" value="<?php echo $stock['quantity']; ?>" required>
        
        <label>Purchase Price:</label>
        <input type="text" name="purchase_price" value="<?php echo $stock['purchase_price']; ?>" required>
        
        <label>Supplier Name:</label>
        <input type="text" name="supplier_name" value="<?php echo $stock['supplier_name']; ?>" required>
        
        <label>Purchase Date:</label>
        <input type="date" name="purchase_date" value="<?php echo $stock['purchase_date']; ?>" required>
        
        <label>Expiry Date:</label>
        <input type="date" name="expiry_date" value="<?php echo $stock['expiry_date']; ?>">
        
        <button type="submit" name="update">Update Stock</button>
    </form>

</body>
</html>









