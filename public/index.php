<?php
session_start();
$cartCount = 0;

if (!empty($_SESSION['cart'])) {
    $cartCount = array_sum($_SESSION['cart']);
}


$page = $_GET['page'] ?? 'home';

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

    case 'about':
        (new PageController())->about();
        break;

    case 'contact':
        (new PageController())->contact();
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


    default:
        echo "404 Page not found";
}
