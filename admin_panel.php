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
        .header, .logout {
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
        .btn-add:hover {
            background-color: #218838;
        }
        .form-control {
            margin-bottom: 10px;
        }
        .divider {
            border-left: 1px solid black;
            height: 100%;
        }
    </style>
    <title>Admin Panel</title>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="header">
                    Type: Admin
                </div>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Username</th>
                            <th>Password</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="userTable">
                        <?php
                        $conn = new mysqli('localhost', 'root', '', 'ProductMS');

                        if ($conn->connect_error) {
                            die("Connection failed: " . $conn->connect_error);
                        }

                        $sql = "SELECT username, password FROM users";
                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) {
                            while($row = $result->fetch_assoc()) {
                        ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($row['username']); ?></td>
                                    <td><?php echo htmlspecialchars($row['password']); ?></td>
                                    <td>
                                        <button class="btn btn-delete" onclick="deleteUser('<?php echo addslashes($row['username']); ?>')">Delete</button>
                                    </td>
                                </tr>
                        <?php
                            }
                        }
                        $conn->close();
                        ?>
                    </tbody>
                </table>
                <div class="row mb-2">
                    <div class="col">
                        <button class="btn btn-update form-control" onclick="window.location.href = 'update_user.php?username=' + document.getElementById('newUsername').value + '&password=' + document.getElementById('newPassword').value">Update</button>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col">
                        <input type="text" class="form-control" placeholder="New Username" id="newUsername">
                    </div>
                    <div class="col">
                        <input type="password" class="form-control" placeholder="Password" id="newPassword">
                    </div>
                    <div class="col">
                        <button class="btn btn-add form-control" onclick="window.location.href='add_user.php?username='+document.getElementById('newUsername').value+'&password='+document.getElementById('newPassword').value">Add User</button>
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
                    <tbody id="productTable">
                        <?php
                        $conn = new mysqli('localhost', 'root', '', 'ProductMS');

                        if ($conn->connect_error) {
                            die("Connection failed: " . $conn->connect_error);
                        }

                        $sql = "SELECT * FROM products";
                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) {
                            while($row = $result->fetch_assoc()) {
                        ?>
                                <tr>
                                    <td><?php echo $row['name']; ?></td>
                                    <td><?php echo $row['price']; ?></td>
                                    <td><?php echo $row['quantity']; ?></td>
                                    <td>
                                        <button class="btn btn-delete" onclick="deleteProduct('<?php echo addslashes($row['name']); ?>')">Delete</button> </td>
                                </tr>
                        <?php
                            }
                        }
                        $conn->close();
                        ?>
                    </tbody>
                </table>
                <div class="row mb-2">
                    <div class="col">
                        <button class="btn btn-update form-control" onclick="updateProduct()">Update</button>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col">
                        <input type="text" class="form-control" placeholder="New Product" id="newProduct">
                    </div>
                    <div class="col">
                        <input type="text" class="form-control" placeholder="Price" id="newPrice">
                    </div>
                    <div class="col">
                        <input type="text" class="form-control" placeholder="Quantity" id="newQuantity">
                    </div>
                    <div class="col">
                        <button class="btn btn-add form-control" onclick="addProduct()">Add Product</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<script>
    function deleteUser(username) {
        if (confirm("Are you sure you want to delete this user?")) {
            window.location.href = "delete_user.php?username=" + username;
        }
    }
    function deleteProduct(product) {
        if (confirm("Are you sure you want to delete this product?")) {
            window.location.href = "delete_product.php?product=" + product;
        }
    }
    function addProduct() {
        var product = document.getElementById("newProduct").value;
        var price = document.getElementById("newPrice").value;
        var quantity = document.getElementById("newQuantity").value;
        window.location.href = "add_product.php?product=" + product + "&price=" + price + "&quantity=" + quantity;
    }
    function updateProduct() {
        var product = document.getElementById("newProduct").value;
        var price = document.getElementById("newPrice").value;
        var quantity = document.getElementById("newQuantity").value;
        window.location.href = "update_product.php?product=" + product + "&price=" + price + "&quantity=" + quantity;
    }
    
    function addUser() {
        var username = document.getElementById("newUsername").value;
        var password = document.getElementById("newPassword").value;
        window.locaiton.href = "add_user.php?username=" + username + "&password=" + password;
    }
    function logOut(){
        window.location.href = "login_page.php";
    }
</script>
</html>

