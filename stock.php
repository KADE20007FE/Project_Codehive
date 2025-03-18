
<?php
include 'db_connect.php'; // Ensure this file connects to the database

// Fetch all stocks
$query = "SELECT s.id, p.name AS product_name, p.category, s.quantity, 
                 s.purchase_price, s.supplier_name, s.purchase_date, s.expiry_date, s.Added_date 
          FROM Stocks s 
          JOIN Products p ON s.product_id = p.id";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stock List</title>
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
        table {
            width: 90%;
            margin: auto;
            border-collapse: collapse;
            background: white;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            overflow: hidden;
        }
        th, td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: center;
        }
        th {
            background: #007bff;
            color: white;
        }
        button {
            padding: 10px 15px;
            margin: 20px;
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
        a {
            color: #007bff;
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <h2>Stock List</h2>
    
    <table>
        <tr>
            <th>Stock ID</th>
            <th>Product Name</th>
            <th>Category</th>
            <th>Quantity</th>
            <th>Purchase Price</th>
            <th>Supplier Name</th>
            <th>Purchase Date</th>
            <th>Expiry Date</th>
            <th>Added Date</th>
            <th>Actions</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()) { ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo $row['product_name']; ?></td>
                <td><?php echo $row['category']; ?></td>
                <td><?php echo $row['quantity']; ?></td>
                <td><?php echo $row['purchase_price']; ?></td>
                <td><?php echo $row['supplier_name']; ?></td>
                <td><?php echo $row['purchase_date']; ?></td>
                <td><?php echo $row['expiry_date']; ?></td>
                <td><?php echo $row['Added_date']; ?></td>
                <td>
                    <a href="update_stock.php?id=<?php echo $row['id']; ?>">Update</a>
                </td>
            </tr>
        <?php } ?>
    </table>

    <button onclick="window.location.href='add_stock.php';">+ Add Stock</button>

</body>
</html>







