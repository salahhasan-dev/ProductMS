<?php
    if (isset($_POST['username']) && isset($_POST['password'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];
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
            echo '<script>alert("Username already exists!"); window.location.href="index.php";</script>';
        } else {
            $sql = "INSERT INTO users (username, password) VALUES (?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('ss', $username, $password);
            $stmt->execute();
            header('Location: index.php');
        }
        $stmt->close();
        $conn->close();
        exit;
    }
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <style>
        body, html {
            height: 100%;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #333;
        }
        .card {
            width: 100%;
            max-width: 400px;
            padding: 20px;
            border-radius: 10px;
            background-color: #b3b3b3;
        }
        .form-control {
            margin-bottom: 15px;
        }
        .btn-register {
            background-color: #28a745;
            color: white;
            width: 100%;
        }
        .btn-register:hover {
            background-color: #218838;
        }
        .login-link {
            text-align: center;
            margin-top: 10px;
        }
        .login-link a {
            color: #007bff;
            text-decoration: none;
        }
        .login-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="card">
        <form method="post">
            <div class="mb-3">
                <input type="text" class="form-control" id="username" placeholder="Username" name="username">
            </div>
            <div class="mb-3">
                <input type="password" class="form-control" id="password" placeholder="Password" name="password">
            </div>
            <button type="submit" class="btn btn-register">Register</button>
            <div class="login-link">
                <p>Already have an account? <a href="login_page.php">Login</a></p>
            </div>
        </form>
    </div>
</body>
</html>
