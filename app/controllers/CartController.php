<?php

require_once __DIR__ . '/../config/Database.php';

class CartController
{
        public function add()
        {
            if (!isset($_SESSION['user'])) {
                header("Location: ?page=login");
                exit;
            }

            if (!isset($_POST['product_id'])) {
                header("Location: ?page=home");
                exit;
            }

            $productId = (int) $_POST['product_id'];

            if (!isset($_SESSION['cart'])) {
                $_SESSION['cart'] = [];
            }

            if (isset($_SESSION['cart'][$productId])) {
                $_SESSION['cart'][$productId]++;
            } else {
                $_SESSION['cart'][$productId] = 1;
            }

            header("Location: ?page=cart");
            exit;
        }


    public function index()
    {
        $cartItems = [];

        if (!empty($_SESSION['cart'])) {
            $db = new Database();
            $conn = $db->connect();

            foreach ($_SESSION['cart'] as $productId => $qty) {
                $stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
                $stmt->execute([$productId]);
                $product = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($product) {
                    $product['quantity'] = $qty;
                    $product['product_id'] = $productId;
                    $cartItems[] = $product;
                }
            }
        }

        require "../app/views/cart/index.php";
    }

    public function remove()
    {
        if (!isset($_GET['id'])) {
            header("Location: ?page=cart");
            exit;
        }

        $productId = (int) $_GET['id'];

        if (isset($_SESSION['cart'][$productId])) {
            unset($_SESSION['cart'][$productId]);
        }

        // IMPORTANT: redirect so navbar recalculates
        header("Location: ?page=cart");
        exit;
    }

    public function inc()
{
    if (!isset($_GET['id'])) {
        header("Location: ?page=cart");
        exit;
    }

    $productId = (int) $_GET['id'];

    if (!isset($_SESSION['cart'][$productId])) {
        $_SESSION['cart'][$productId] = 1;
    } else {
        $_SESSION['cart'][$productId]++;
    }

    header("Location: ?page=cart");
    exit;
}

    public function dec()
    {
        if (!isset($_GET['id'])) {
            header("Location: ?page=cart");
            exit;
        }

        $productId = (int) $_GET['id'];

        if (isset($_SESSION['cart'][$productId])) {
            $_SESSION['cart'][$productId]--;

            // if quantity hits 0, remove item
            if ($_SESSION['cart'][$productId] <= 0) {
                unset($_SESSION['cart'][$productId]);
            }
        }

        header("Location: ?page=cart");
        exit;
    }


}
