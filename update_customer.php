<?php
require 'db_connect.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM Customers WHERE id='$id'";
    $result = $conn->query($sql);
    $customer = $result->fetch_assoc();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $address = $_POST['address'];

    $sql = "UPDATE Customers SET name='$name', phone='$phone', email='$email', address='$address' WHERE id='$id'";

    if ($conn->query($sql) === TRUE) {
        echo "Customer updated successfully!";
        header("Location: customers.php");
        exit();
    } else {
        echo "Error updating customer: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Customer</title>
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
        input, textarea {
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

    <h2>Update Customer</h2>

    <form method="POST">
        <input type="hidden" name="id" value="<?php echo $customer['id']; ?>">
        
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" value="<?php echo $customer['name']; ?>" required>
        
        <label for="phone">Phone:</label>
        <input type="text" id="phone" name="phone" value="<?php echo $customer['phone']; ?>" required>
        
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="<?php echo $customer['email']; ?>" required>
        
        <label for="address">Address:</label>
        <textarea id="address" name="address"><?php echo $customer['address']; ?></textarea>
        
        <button type="submit">Update Customer</button>
    </form>

</body>
</html>






