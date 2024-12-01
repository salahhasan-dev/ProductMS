<?php
// add product functionality
if (isset($_GET['username']) && isset($_GET['password'])) {
    $username = $_GET['username'];
    $password = $_GET['password'];
    $conn = new mysqli('localhost', 'root', '', 'ProductMS');
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $sql = "SELECT * FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows > 0) {
        echo '<script>alert("Username already exists!"); window.location.href="admin_panel.php";</script>';
    } else {
        $sql = "INSERT INTO users (username, password) VALUES (?, ?)"; // table name was wrong
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ss', $username, $password); // binding parameters was wrong
        $stmt->execute();
        $stmt->close();
        $conn->close();
        header('Location: admin_panel.php');
    }
}
?>

