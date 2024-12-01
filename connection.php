<?php
// connect to database
$conn = new mysqli('localhost', 'root', '', 'ProductMS');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>