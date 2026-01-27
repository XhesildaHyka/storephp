<?php
require_once "auth.php";
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
</head>
<body>

<h1>Admin Dashboard</h1>

<p>Welcome, <?= $_SESSION['user']['name'] ?></p>

<ul>
    <li><a href="products.php">Manage Products</a></li>
    <li><a href="banners.php">Manage Banners</a></li>
    <li><a href="/store-system/public/?page=logout">Logout</a></li>
</ul>

</body>
</html>
