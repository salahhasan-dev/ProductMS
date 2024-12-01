<?php
if (isset($_GET['product']) && isset($_GET['quantity'])) {
    $selectedProduct = $_GET['product'];
    $selectedQuantity = $_GET['quantity'];
}

// connect to database
session_start();
$conn = new mysqli('localhost', 'root', '', 'ProductMS');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// add selected items to cart
if (isset($selectedProduct) && isset($selectedQuantity)) {
    $username = $_SESSION['username'];

    // Check if the quantity in products table is less than the added product quantity
    $checkQuantitySql = "SELECT quantity FROM products WHERE name = ?";
    $checkStmt = $conn->prepare($checkQuantitySql);
    $checkStmt->bind_param('s', $selectedProduct);
    $checkStmt->execute();
    $checkStmt->bind_result($availableQuantity);
    $checkStmt->fetch();
    $checkStmt->close();

    if ($availableQuantity >= $selectedQuantity) {
        $sql = "INSERT INTO cart (product_name, username, price, quantity) VALUES (?, ?, (SELECT price FROM products WHERE name = ?), ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('sssi', $selectedProduct, $username, $selectedProduct, $selectedQuantity);
        $stmt->execute();
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => 'Insufficient quantity available']);
        header('Location: panel.php');
    }

    $stmt->close();
}
$conn->close();
header('Location: panel.php');
?>

