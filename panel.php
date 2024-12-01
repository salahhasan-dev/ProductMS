<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <style>
        body {
            background-color: #333;
        }

        .container {
            background-color: #999;
            padding: 20px;
            border-radius: 10px;
            margin-top: 20px;
        }

        .header,
        .logout {
            background-color: #ccc;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 20px;
        }

        .logout {
            text-align: right;
        }

        .btn-delete {
            background-color: #a00;
            color: white;
        }

        .btn-delete:hover {
            background-color: #d83838;
        }
        
        .btn-add:hover {
            background-color: #218838;
        }

        .btn-update {
            background-color: #0a0;
            color: white;
        }

        .btn-update:hover {
            background-color: #218838;
        }

        .btn-add {
            background-color: #0a0;
            color: white;
        }

        .form-control {
            margin-bottom: 10px;
        }

        .divider {
            border-left: 1px solid black;
            height: 100%;
        }
    </style>

    <title>Customer Panel</title>
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="header">
                    Welcome, <?php session_start();
                                echo isset($_SESSION['username']) ? htmlspecialchars($_SESSION['username']) : ''; ?>
                </div>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Price</th>
                            <th>Available Quantity</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="productTable">
                        <?php


                        $conn = new mysqli('localhost', 'root', '', 'ProductMS');

                        if ($conn->connect_error) {
                            die("Connection failed: " . $conn->connect_error);
                        }

                        $sql = "SELECT * FROM products";
                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>
                                            <td>" . htmlspecialchars($row['name']) . "</td>
                                            <td>" . htmlspecialchars($row['price']) . "</td>
                                            <td>" . htmlspecialchars($row['quantity']) . "</td>
                                            <td><button class='btn btn-add' onclick=\"selectProduct('" . addslashes($row['name']) . "', " . addslashes($row['price']) . ", " . addslashes($row['quantity']) . ")\">Select</button></td>
                                        </tr>";
                            }
                        }

                        $conn->close();
                        ?>
                    </tbody>
                </table>
                <div class="row mb-2">
                    <div class="col">
                        <input type="text" class="form-control" placeholder="Product" id="selectedProduct" readonly>
                    </div>
                    <div class="col">
                        <input type="number" class="form-control" placeholder="Quantity" id="selectedQuantity">
                    </div>
                    <div class="col">
                        <button class="btn btn-add form-control" onclick="window.location.href = 'add_to_cart.php?product=' + document.getElementById('selectedProduct').value + '&quantity=' + document.getElementById('selectedQuantity').value;">Add to Cart</button>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="logout">
                    Username <button class="btn btn-delete" onclick="logOut()">Logout</button>
                </div>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="cartTable">
                        <tr>


                        <?php

                        $conn = new mysqli('localhost', 'root', '', 'ProductMS');

                        if ($conn->connect_error) {
                            die("Connection failed: " . $conn->connect_error);
                        }

                        $sql = "SELECT * FROM cart WHERE username = ?";
                        $stmt = $conn->prepare($sql);
                        $stmt->bind_param('s', $_SESSION['username']);
                        $stmt->execute();
                        $result = $stmt->get_result();

                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>
                                            <td>" . htmlspecialchars($row['product_name']) . "</td>
                                            <td>" . htmlspecialchars($row['price']) . "</td>
                                            <td>" . htmlspecialchars($row['quantity']) . "</td>"
                                ?>
                            <td>
                                    <a href="remove_from_cart.php?product=<?php echo $row['product_name'] ?>&price=<?php echo $row['price'] ?>&quantity=<?php echo $row['quantity'] ?>" class="btn btn-delete">Delete</a>
                                    
                            </td>
                                <?php
                            }
                        }


                        $conn->close();
                        ?>
                        </tr>
                    </tbody>
                </table>
<div class="row mb-2">
    <div class="col">
        <?php
        $totalPrice = 0;
        $conn = new mysqli('localhost', 'root', '', 'ProductMS');

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $sql = "SELECT price, quantity FROM cart WHERE username = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('s', $_SESSION['username']);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $totalPrice += $row['price'] * $row['quantity'];
            }
        }

        $stmt->close();
        $conn->close();
        ?>
        <div class="form-control">Total Price:  $ <?php echo htmlspecialchars($totalPrice); ?></div>
    </div>
</div>
                <div class="row mb-2">
                    <div class="col">
                        <button class="btn btn-update form-control" onclick="checkout()">Checkout</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        



        function selectProduct(name, price, availableQuantity) {
            document.getElementById('selectedProduct').value = name;
            document.getElementById('selectedQuantity').max = availableQuantity;
        }

        function checkout() {
            window.location.href = "checkout.php";
        }



        function removeFromCart(product_name, price, quantity, username) {
            // call a PHP function to remove the item from the cart
            window.location.href = "remove_from_cart.php?product=" + product_name + "&price=" + price + "&quantity=" + quantity + "&username=" + username;
        }

        function logOut() {
            window.location.href = "login_page.php";
        }
    </script>
</body>

</html>
