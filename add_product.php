<?php
// add product functionality
if (isset($_GET['product']) && isset($_GET['price']) && isset($_GET['quantity'])) {
    $product = $_GET['product'];
    $price = $_GET['price'];
    $quantity = $_GET['quantity'];
    $conn = new mysqli('localhost', 'root', '', 'ProductMS');
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $sql = "SELECT * FROM products WHERE name = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $product);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows == 0) {
        $sql = "INSERT INTO products (name, price, quantity) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('sii', $product, $price, $quantity);
        $stmt->execute();
    }
    $stmt->close();
    $conn->close();
    header('Location: admin_panel.php');
}
?>
