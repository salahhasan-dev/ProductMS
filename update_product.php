<?php
// update product functionality
if (isset($_GET['product']) && isset($_GET['price']) && isset($_GET['quantity'])) {
    // connect to database
    $conn = new mysqli('localhost', 'root', '', 'ProductMS');
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // get product name, price, and quantity from GET request
    $product = $_GET['product'];
    $price = $_GET['price'];
    $quantity = $_GET['quantity'];

    // check if the product exists
    $sql = "SELECT * FROM products WHERE name = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $product);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        // update product quantity and price
        $sql = "UPDATE products SET price = ?, quantity = ? WHERE name = ?";
        $stmt->close(); // close previous statement
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('dis', $price, $quantity, $product); // 'd' for price, 'i' for quantity, 's' for name
        $stmt->execute();
    }

    $stmt->close();
    $conn->close();
    header('Location: admin_panel.php');
    exit();
}
?>
