<?php
// connect to database
$conn = new mysqli('localhost', 'root', '', 'ProductMS');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// get product name and quantity from POST request
$name = $_GET['username'];
$password = $_GET['password'];

// update username password
$sql = "UPDATE users SET username = ?, password = ? WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('sss', $name, $password, $name); // Corrected variable from $quantity to $password
$stmt->execute();
$stmt->close();
$conn->close();
echo json_encode(['success' => true]);
header('Location: admin_panel.php');
?>
