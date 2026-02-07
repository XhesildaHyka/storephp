<?php require "../app/views/layouts/header.php"; ?>

<div class="product-page">
    <div class="product-left">
        <img class="product-image"
             src="/store-system/public/uploads/<?= htmlspecialchars($product['image']) ?>"
             alt="<?= htmlspecialchars($product['name']) ?>">
    </div>

    <div class="product-right">
        <h2><?= htmlspecialchars($product['name']) ?></h2>

        <div class="product-price">
            $<?= number_format((float)$product['price'], 2) ?>
            <?php if (!empty($product['is_offer']) && (int)$product['discount_percent'] > 0) : ?>
            <span class="old-price">
                $<?= number_format((float)$product['original_price'], 2) ?>
            </span>

            <?php endif; ?>
        </div>

        <?php if (!empty($product['description'])) : ?>
            <p class="product-desc"><?= nl2br(htmlspecialchars($product['description'])) ?></p>
        <?php endif; ?>

        <?php if (!empty($product['material'])) : ?>
            <p class="product-meta"><b>Material:</b> <?= htmlspecialchars($product['material']) ?></p>
        <?php endif; ?>



        <h4 style="margin-top:18px;">Choose Size</h4>

        <?php if (empty($sizes)) : ?>
            <p style="color:#c00;font-weight:600;">No sizes added for this product yet (admin must set stock).</p>
        <?php else : ?>
            <form method="POST" action="?page=add-to-cart" class="size-form">
                <input type="hidden" name="product_id" value="<?= (int)$product['id'] ?>">

                <div class="size-grid">
                    <?php foreach ($sizes as $s): ?>
                        <?php $out = ((int)$s['stock'] <= 0); ?>
                        <label class="size-pill <?= $out ? 'disabled' : '' ?>">
                            <input type="radio" name="size" value="<?= htmlspecialchars($s['size']) ?>" <?= $out ? 'disabled' : '' ?> required>
                            <?= htmlspecialchars($s['size']) ?>
                        </label>
                    <?php endforeach; ?>
                </div>

                <button type="submit" class="btn-primary btn-block">🛒 Add to Cart</button>

                <?php if (!isset($_SESSION['user'])): ?>
                    <p style="margin-top:10px;color:#555;">You will be asked to login before adding to cart.</p>
                <?php endif; ?>
            </form>
        <?php endif; ?>
    </div>
</div>

<?php require "../app/views/layouts/footer.php"; ?>
