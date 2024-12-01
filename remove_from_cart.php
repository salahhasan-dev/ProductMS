<?php
// connect to database
session_start();
$conn = new mysqli('localhost', 'root', '', 'ProductMS');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// remove the row from cart database, based on the given data
if (isset($_SESSION['username'])) {
    $sql = "DELETE FROM cart WHERE product_name = ? AND price = ? AND quantity = ? AND username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ssis', $_GET['product'], $_GET['price'], $_GET['quantity'], $_SESSION['username']);
    $stmt->execute();
    $stmt->close();
    $conn->close();
    echo json_encode(['success' => true]);
    header('Location: panel.php');
} else {
    echo json_encode(['success' => false, 'error' => 'Not logged in']);
    header('Location: panel.php');
}

