<?php
session_start();
// connect to database
$conn = new mysqli('localhost', 'root', '', 'ProductMS');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
// add checkout funtiontlity
if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
    $sql = "SELECT product_name, quantity FROM cart WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $product_name = $row['product_name'];
            $quantity = $row['quantity'];
            $sql2 = "UPDATE products SET quantity = quantity - ? WHERE name = ?";
            $stmt2 = $conn->prepare($sql2);
            $stmt2->bind_param('is', $quantity, $product_name);
            $stmt2->execute();
        }
    }
    $stmt->close();
    $sql = "DELETE FROM cart WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $stmt->close();
    $conn->close();
    header('Location: panel.php');
}
?>
