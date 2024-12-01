<?php
// add delete user functionality
if (isset($_GET['username'])) {
    $username = $_GET['username'];
    $conn = new mysqli('localhost', 'root', '', 'ProductMS');
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $sql = "SELECT role FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $stmt->bind_result($role);
    $stmt->fetch();
    $stmt->close();
    if ($role != 'admin') {
        $sql = "DELETE FROM users WHERE username = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $stmt->close();
    }
    $conn->close();
    header('Location: admin_panel.php');
}
?>
