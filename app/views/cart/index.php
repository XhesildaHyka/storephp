<?php
require __DIR__ . '/../layouts/header.php';
$backUrl = $_SESSION['shop_back'] ?? '?page=home';

$grandTotal = 0;
?>

<?php if (!empty($_SESSION['order_success'])) : ?>
    <div class="success-box">
        <?= htmlspecialchars($_SESSION['order_success']) ?>
    </div>
    <?php unset($_SESSION['order_success']); ?>
<?php endif; ?>


<div class="cart-page">

    <div class="cart-top">
        <h2 class="cart-title">🛒 Your Cart</h2>

        <?php if (!empty($_SESSION['cart'])) : ?>
            <a href="?page=clear-cart" class="btn-clear-cart">🧹 Clear cart</a>
        <?php endif; ?>
    </div>

    <?php if (empty($cartItems)) : ?>
        <div class="cart-empty">
            <p>Your cart is empty.</p>
            <a href="<?= htmlspecialchars($backUrl) ?>"
               class="btn-secondary btn-block">
               Continue shopping
            </a>
        </div>

    <?php else : ?>

        <div class="cart-layout">

            <!-- LEFT: items -->
            <div class="cart-items">

                <?php foreach ($cartItems as $item) : ?>
                    <?php
                        $qty = (int)($item['quantity'] ?? 1);
                        $price = (float)($item['price'] ?? 0);
                        $lineTotal = $price * $qty;
                        $grandTotal += $lineTotal;

                        // safe fields
                        $size = $item['size'] ?? '';
                        $cartKey = $item['cart_key'] ?? ($item['product_id'] ?? '');
                    ?>

                    <div class="cart-item">
                        <div class="cart-item-img">
                            <img
                                src="/store-system/public/uploads/<?= htmlspecialchars($item['image'] ?? '') ?>"
                                alt="<?= htmlspecialchars($item['name'] ?? '') ?>"
                            >
                        </div>

                        <div class="cart-item-info">
                            <div class="cart-item-name"><?= htmlspecialchars($item['name'] ?? '') ?></div>

                            <div class="cart-item-price">
                                $<?= number_format($price, 2) ?>
                                <?php if ($size !== '') : ?>
                                    <span class="cart-size">Size: <?= htmlspecialchars($size) ?></span>
                                <?php endif; ?>
                            </div>

                            <div class="cart-item-controls">
                                <div class="qty-control">
                                    <a class="qty-btn" href="?page=cart-dec&key=<?= urlencode($cartKey) ?>">−</a>
                                    <span class="qty-number"><?= $qty ?></span>
                                    <a class="qty-btn" href="?page=cart-inc&key=<?= urlencode($cartKey) ?>">+</a>
                                </div>

                                <a class="remove-btn" href="?page=remove-from-cart&key=<?= urlencode($cartKey) ?>">
                                    ✖ Remove
                                </a>
                            </div>
                        </div>

                        <div class="cart-item-total">
                            <div class="label">Total</div>
                            <div class="value">$<?= number_format($lineTotal, 2) ?></div>
                        </div>
                    </div>
                <?php endforeach; ?>

            </div>

            <!-- RIGHT: summary -->
            <aside class="cart-summary">
                <h3>Order Summary</h3>

                <div class="summary-row">
                    <span>Subtotal</span>
                    <span>$<?= number_format($grandTotal, 2) ?></span>
                </div>

                <div class="summary-divider"></div>

                <div class="summary-row total">
                    <span>Total</span>
                    <span>$<?= number_format($grandTotal, 2) ?></span>
                </div>

                <a href="?page=checkout" class="btn-primary btn-block">Checkout</a>
                <a href="<?= htmlspecialchars($backUrl) ?>"
                   class="btn-secondary btn-block">
                   Continue shopping
                </a>

            </aside>

        </div>

    <?php endif; ?>
</div>

<?php require "../app/views/layouts/footer.php"; ?>
