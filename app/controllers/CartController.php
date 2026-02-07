<?php

require_once __DIR__ . '/../config/Database.php';

class CartController
{
    // ✅ ADD TO CART (now requires size)
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

        $productId = (int)($_POST['product_id']);
        $size = trim($_POST['size'] ?? ''); // ✅ from product page

        // if size missing -> go back
        if ($size === '') {
            header("Location: ?page=product&id=" . $productId);
            exit;
        }

        // cart key = "id|size"
        $key = $productId . "|" . $size;

        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }

        if (isset($_SESSION['cart'][$key])) {
            $_SESSION['cart'][$key]++;
        } else {
            $_SESSION['cart'][$key] = 1;
        }

        header("Location: ?page=cart");
        exit;
    }

    // ✅ CART PAGE (reads keys like "id|size")
    public function index()
    {
        $cartItems = [];

        if (!empty($_SESSION['cart'])) {
            $db = new Database();
            $conn = $db->connect();

            foreach ($_SESSION['cart'] as $key => $qty) {

                // key can be old style (id) or new style (id|size)
                $parts = explode("|", (string)$key);
                $productId = (int)$parts[0];
                $size = $parts[1] ?? '';

                $stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
                $stmt->execute([$productId]);
                $product = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($product) {
                    $product['quantity'] = (int)$qty;
                    $product['product_id'] = $productId;
                    $product['size'] = $size;     // ✅ keep size in view
                    $product['cart_key'] = $key;  // ✅ important for inc/dec/remove links
                    $cartItems[] = $product;
                }
            }
        }

        require "../app/views/cart/index.php";
    }

    // ✅ REMOVE (uses key)
    public function remove()
    {
        // support old id param too
        if (isset($_GET['key'])) {
            $key = (string)$_GET['key'];
        } elseif (isset($_GET['id'])) {
            $key = (string)(int)$_GET['id']; // old style
        } else {
            header("Location: ?page=cart");
            exit;
        }

        if (isset($_SESSION['cart'][$key])) {
            unset($_SESSION['cart'][$key]);
        }

        header("Location: ?page=cart");
        exit;
    }

    // ✅ INCREASE (uses key)
    public function inc()
    {
        if (isset($_GET['key'])) {
            $key = (string)$_GET['key'];
        } elseif (isset($_GET['id'])) {
            $key = (string)(int)$_GET['id']; // old style
        } else {
            header("Location: ?page=cart");
            exit;
        }

        if (!isset($_SESSION['cart'][$key])) {
            $_SESSION['cart'][$key] = 1;
        } else {
            $_SESSION['cart'][$key]++;
        }

        header("Location: ?page=cart");
        exit;
    }

    // ✅ DECREASE (uses key)
    public function dec()
    {
        if (isset($_GET['key'])) {
            $key = (string)$_GET['key'];
        } elseif (isset($_GET['id'])) {
            $key = (string)(int)$_GET['id']; // old style
        } else {
            header("Location: ?page=cart");
            exit;
        }

        if (isset($_SESSION['cart'][$key])) {
            $_SESSION['cart'][$key]--;

            if ($_SESSION['cart'][$key] <= 0) {
                unset($_SESSION['cart'][$key]);
            }
        }

        header("Location: ?page=cart");
        exit;
    }

    // ✅ CHECKOUT PAGE (form)
    public function checkout()
    {
        if (!isset($_SESSION['user']) || empty($_SESSION['cart'])) {
            header("Location: ?page=cart");
            exit;
        }

        require "../app/views/cart/checkout.php";
    }

    // ✅ PLACE ORDER (reads size from cart key)
    public function checkoutProcess()
    {
        if (!isset($_SESSION['user']) || empty($_SESSION['cart'])) {
            header("Location: ?page=cart");
            exit;
        }

        $db = new Database();
        $conn = $db->connect();

        $userId = $_SESSION['user']['id'];
        $phone = trim($_POST['phone'] ?? '');
        $address = trim($_POST['address'] ?? '');

        $total = 0;

        // calculate total properly per cart key
        foreach ($_SESSION['cart'] as $key => $qty) {
            $parts = explode("|", (string)$key);
            $pid = (int)$parts[0];

            $stmt = $conn->prepare("SELECT price FROM products WHERE id = ?");
            $stmt->execute([$pid]);
            $price = (float)$stmt->fetchColumn();

            $total += $price * (int)$qty;
        }

        // create order
        $stmt = $conn->prepare("
            INSERT INTO orders (user_id, total, phone, address)
            VALUES (?, ?, ?, ?)
        ");
        $stmt->execute([$userId, $total, $phone, $address]);
        $orderId = $conn->lastInsertId();

        // order items (includes size) + ✅ reduce stock
        foreach ($_SESSION['cart'] as $key => $qty) {
            $parts = explode("|", (string)$key);
            $pid = (int)$parts[0];
            $size = $parts[1] ?? '';
            $qty = (int)$qty;

            // get price
            $stmt = $conn->prepare("SELECT price FROM products WHERE id = ?");
            $stmt->execute([$pid]);
            $price = (float)$stmt->fetchColumn();

            // insert item
            $stmt2 = $conn->prepare("
                INSERT INTO order_items (order_id, product_id, quantity, price, size)
                VALUES (?, ?, ?, ?, ?)
            ");
            $stmt2->execute([$orderId, $pid, $qty, $price, $size]);

            // ✅ decrease stock for that size
            $upd = $conn->prepare("
                UPDATE product_sizes
                SET stock = stock - ?
                WHERE product_id = ? AND size = ? AND stock >= ?
            ");
            $upd->execute([$qty, $pid, $size, $qty]);

            // optional safety: if stock update failed (not enough stock), stop
            if ($upd->rowCount() === 0) {
                $_SESSION['order_success'] = "❌ Not enough stock for size $size. Please try again.";
                header("Location: ?page=cart");
                exit;
            }
        }


        unset($_SESSION['cart']);

        $_SESSION['order_success'] = "🎉 Thank you! Your order has been placed.";

        header("Location: ?page=cart");
        exit;
    }
}
