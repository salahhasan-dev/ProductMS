<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
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
        .btn-login {
            background-color: #28a745;
            color: white;
            width: 100%;
        }
        .btn-login:hover {
            background-color: #218838;
        }
        .register-link {
            text-align: center;
            margin-top: 10px;
        }
        .register-link a {
            color: #007bff;
            text-decoration: none;
        }
        .register-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="card">
        <form method="post">
            <div class="mb-3">
                <input type="text" class="form-control" id="username" name="username" placeholder="Username">
            </div>
            <div class="mb-3">
                <input type="password" class="form-control" id="password" name="password" placeholder="Password">
            </div>
            <button type="submit" class="btn btn-login">Login</button>
            <div class="register-link">
                <p>Don't have an account? <a href="index.php">Register</a></p>
            </div>
        </form>
        <?php
            if (isset($_POST['username']) && isset($_POST['password'])) {
                $username = $_POST['username'];
                $password = $_POST['password'];
                $user_type = '';
                if ($username == 'admin' && $password == '12345') {
                    $user_type = 'admin';
                } else {
                    // connect to database
                    $conn = new mysqli('localhost', 'root', '', 'ProductMS');
                    if ($conn->connect_error) {
                        die("Connection failed: " . $conn->connect_error);
                    }
                    $sql = "SELECT role FROM users WHERE username = ? AND password = ?";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param('ss', $username, $password);
                    $stmt->execute();
                    $stmt->bind_result($user_type);
                    $stmt->fetch();
                    $stmt->close();
                    $conn->close();
                }
                if ($user_type == 'admin') {
                    header('Location: admin_panel.php');
                    // add session and start
                    session_start();
                    $_SESSION['username'] = $username;

                } else if ($user_type == 'user') {
                    header('Location: panel.php');
                    // add session and start
                    session_start();
                    if (!isset($_SESSION)) {
                        $_SESSION = array();
                    }
                    $_SESSION['username'] = $username;
                } else {
                    echo '<div class="alert alert-danger" role="alert">Incorrect username or password.</div>';
                }
            }
        ?>
    </div>
</body>
</html>