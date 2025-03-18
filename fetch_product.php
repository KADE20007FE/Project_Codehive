<?php
include "db_connect.php"; // Ensure this file connects to your database

if (isset($_GET['product_id']) && !empty($_GET['product_id'])) {
    $productID = $_GET['product_id'];

    // Fetch product details along with stock quantity
    $query = "SELECT P.name AS product_name, P.Selling_price AS selling_price, 
                     COALESCE(SUM(S.quantity), 0) AS available_stock
              FROM Products P
              LEFT JOIN Stocks S ON P.id = S.product_id
              WHERE P.id = ?
              GROUP BY P.id, P.name, P.Selling_price";

    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $productID);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        echo json_encode([
            "success" => true,
            "product_name" => $row["product_name"],
            "selling_price" => $row["selling_price"],
            "available_stock" => $row["available_stock"]
        ]);
    } else {
        echo json_encode(["success" => false, "message" => "Product not found"]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Invalid request. Product ID not received."]);
}
?>