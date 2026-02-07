<?php
session_start();

$page = $_GET['page'] ?? 'home';

// ✅ Save ONLY category/home as return target (never product)
if ($_SERVER['REQUEST_METHOD'] === 'GET' && in_array($page, ['home', 'category'])) {
    $_SESSION['shop_back'] = $_SERVER['REQUEST_URI'];
}

require_once "../app/controllers/HomeController.php";
require_once "../app/controllers/ProductController.php";
require_once "../app/controllers/PageController.php";
require_once "../app/controllers/AuthController.php";
require_once "../app/controllers/CartController.php";

switch ($page) {

    case 'home':
        (new HomeController())->index();
        break;

    case 'category':
        (new ProductController())->category();
        break;

    case 'product':
        (new ProductController())->show();
        break;

    case 'about':
        (new PageController())->about();
        break;

    case 'contact':
        (new PageController())->contact();
        break;

    // ✅ ONLY ONE route for sending contact form
    case 'contact-send':
        (new PageController())->contactProcess();
        break;

    case 'search':
        (new ProductController())->search();
        break;

    case 'login':
        (new AuthController())->login();
        break;

    case 'login-process':
        (new AuthController())->authenticate();
        break;

    case 'logout':
        (new AuthController())->logout();
        break;

    case 'register':
        (new AuthController())->register();
        break;

    case 'register-process':
        (new AuthController())->registerProcess();
        break;

    case 'cart':
        (new CartController())->index();
        break;

    case 'add-to-cart':
        (new CartController())->add();
        break;

    case 'remove-from-cart':
        (new CartController())->remove();
        break;

    case 'clear-cart':
        unset($_SESSION['cart']);
        header("Location: ?page=cart");
        exit;

    case 'cart-inc':
        (new CartController())->inc();
        break;

    case 'cart-dec':
        (new CartController())->dec();
        break;

    case 'checkout':
        (new CartController())->checkout();
        break;

    case 'checkout-process':
        (new CartController())->checkoutProcess();
        break;

    default:
        echo "404 Page not found";
}
