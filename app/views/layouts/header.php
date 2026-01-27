<?php
// if (session_status() === PHP_SESSION_NONE) {
//     session_start();
// }

$cartCount = isset($_SESSION['cart'])
    ? array_sum($_SESSION['cart'])
    : 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Store</title>
    <link rel="stylesheet" href="/store-system/public/css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">

</head>
<body>

    <header class="main-header" id="mainHeader" >

        <div class="nav-container">

            <!-- LOGO -->
            <div class="logo">
                <a href="?page=home">MyStore</a>
            </div>

            <!-- NAV LINKS -->
            <nav class="main-nav">
                <a href="?page=home">Home</a>
                <a href="?page=about">About</a>
                <a href="?page=contact">Contact</a>

                <div class="dropdown">
                    <span>Shoes</span>
                    <div class="dropdown-menu">
                        <a href="?page=category&cat=shoes&gen=women">Women</a>
                        <a href="?page=category&cat=shoes&gen=men">Men</a>
                        <a href="?page=category&cat=shoes&gen=kids">Kids</a>
                    </div>
                </div>

                <div class="dropdown">
                    <span>Clothes</span>
                    <div class="dropdown-menu">
                        <a href="?page=category&cat=clothes&gen=women">Women</a>
                        <a href="?page=category&cat=clothes&gen=men">Men</a>
                        <a href="?page=category&cat=clothes&gen=kids">Kids</a>
                    </div>
                </div>
            </nav>

            <!-- AUTH -->
    <div class="auth-links">
        <?php if (isset($_SESSION['user'])) : ?>

            <!-- CART ICON -->
            <a href="?page=cart" class="cart-link">
                🛒
                <?php if (!empty($cartCount)) : ?>
                    <span class="cart-count"><?= $cartCount ?></span>
                <?php endif; ?>
            </a>

            <!-- LOGOUT -->
            <a href="?page=logout" class="btn">Logout</a>

        <?php else : ?>

            <!-- LOGIN -->
            <a href="?page=login" class="btn">Login</a>

        <?php endif; ?>
    </div>

    </header>
    <script src="/store-system/public/js/slider.js"></script>  
</body>