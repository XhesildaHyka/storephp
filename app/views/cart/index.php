<?php
// (Optional) include header layout if you use it
require __DIR__ . '/../layouts/header.php';

$grandTotal = 0;
?>

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
            <a href="?page=home" class="btn-primary">Continue shopping</a>
        </div>
    <?php else : ?>

        <div class="cart-layout">

            <!-- LEFT: items -->
            <div class="cart-items">

                <?php foreach ($cartItems as $item) : ?>
                    <?php
                        $lineTotal = $item['price'] * $item['quantity'];
                        $grandTotal += $lineTotal;
                    ?>

                    <div class="cart-item">
                        <div class="cart-item-img">
                            <img
                                src="/store-system/public/uploads/<?= htmlspecialchars($item['image']) ?>"
                                alt="<?= htmlspecialchars($item['name']) ?>"
                            >
                        </div>

                        <div class="cart-item-info">
                            <div class="cart-item-name"><?= htmlspecialchars($item['name']) ?></div>
                            <div class="cart-item-price">$<?= number_format($item['price'], 2) ?></div>

                            <div class="cart-item-controls">
                                <div class="qty-control">
                                    <a class="qty-btn" href="?page=cart-dec&id=<?= $item['product_id'] ?>">−</a>
                                    <span class="qty-number"><?= (int)$item['quantity'] ?></span>
                                    <a class="qty-btn" href="?page=cart-inc&id=<?= $item['product_id'] ?>">+</a>
                                </div>

                                <a class="remove-btn" href="?page=remove-from-cart&id=<?= $item['product_id'] ?>">
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

                <div class="summary-row">
                    <span>Shipping</span>
                    <span class="muted">Calculated at checkout</span>
                </div>

                <div class="summary-divider"></div>

                <div class="summary-row total">
                    <span>Total</span>
                    <span>$<?= number_format($grandTotal, 2) ?></span>
                </div>

                <a href="?page=checkout" class="btn-primary btn-block">Checkout</a>
                <a href="?page=home" class="btn-secondary btn-block">Continue shopping</a>
            </aside>

        </div>

    <?php endif; ?>
</div>

<?php
// (Optional) include footer layout if you use it
// require __DIR__ . '/../layouts/footer.php';
?>
