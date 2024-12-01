<?php
// add delete product functionality
if (isset($_GET['product'])) {
    $product = $_GET['product'];
    $conn = new mysqli('localhost', 'root', '', 'ProductMS');
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $sql = "DELETE FROM products WHERE name = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $product);
    $stmt->execute();
    $stmt->close();
    $conn->close();
    header('Location: admin_panel.php');
}
?>