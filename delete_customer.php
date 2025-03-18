<?php
require 'db_connect.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "DELETE FROM Customers WHERE id='$id'";

    if ($conn->query($sql) === TRUE) {
        echo "Customer deleted successfully!";
    } else {
        echo "Error deleting customer: " . $conn->error;
    }
    header("Location: customers.php");
  exit();
}
?>