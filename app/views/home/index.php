<?php require "../app/views/layouts/header.php"; ?>

<div class="carousel">
<?php $i = 0; ?>
<?php while ($b = $banners->fetch(PDO::FETCH_ASSOC)) : ?>
    <div class="slide <?= $i === 0 ? 'active' : '' ?>">
        <img src="/store-system/public/images/<?= $b['image'] ?>">
        <div class="caption">
            <h2><?= htmlspecialchars($b['title']) ?></h2>
            <p><?= htmlspecialchars($b['subtitle']) ?></p>
        </div>
    </div>
<?php $i++; endwhile; ?>
</div>



<!-- arrivals -->

<h2 class="section-title">🔥 New Arrivals</h2>

<div class="slider-wrapper">
    <button class="slider-btn left" onclick="slideLeft()">&#10094;</button>

    <div class="slider" id="arrivalSlider">
        <?php while ($row = $newArrivals->fetch(PDO::FETCH_ASSOC)) : ?>
            <div class="product-card">
                <img src="/store-system/public/uploads/<?= htmlspecialchars($row['image']) ?>">

                <h4><?= htmlspecialchars($row['name']) ?></h4>
                <p>$<?= number_format($row['price'], 2) ?></p>

                <?php if (isset($_SESSION['user'])) : ?>
                    <form method="POST" action="?page=add-to-cart">
                        <input type="hidden" name="product_id" value="<?= $row['id'] ?>">
                        <button type="submit" class="btn-cart">
                            🛒 Add to Cart
                        </button>
                    </form>
                <?php else : ?>
                    <a href="?page=login" class="btn-cart">
                        🔒 Login to buy
                    </a>
                <?php endif; ?>
            </div>
        <?php endwhile; ?>
    </div>

    <button class="slider-btn right" onclick="slideRight()">&#10095;</button>
</div>


<!-- offers -->
<h2 class="section-title">💸 Offers</h2>

<div class="slider-wrapper">
    <button class="slider-btn left" onclick="slideLeft('offersSlider')">&#10094;</button>

    <div class="slider" id="offersSlider">
        <?php while ($row = $offers->fetch(PDO::FETCH_ASSOC)) : ?>
            <div class="product-card offer">
                <img src="/store-system/public/uploads/<?= htmlspecialchars($row['image']) ?>">

                <h4><?= htmlspecialchars($row['name']) ?></h4>

                <?php if (!empty($row['is_offer']) && (int)$row['discount_percent'] > 0) : ?>
                    <p class="old-price">$<?= number_format($row['original_price'], 2) ?></p>
                <?php endif; ?>

                <p class="price">$<?= number_format($row['price'], 2) ?></p>

                <?php if (!empty($row['is_offer']) && (int)$row['discount_percent'] > 0) : ?>
                    <span class="discount-badge">-<?= (int)$row['discount_percent'] ?>%</span>
                <?php endif; ?>


                <?php if (isset($_SESSION['user'])) : ?>
                    <form method="POST" action="?page=add-to-cart">
                        <input type="hidden" name="product_id" value="<?= $row['id'] ?>">
                        <button type="submit" class="btn-cart">
                            🛒 Add to Cart
                        </button>
                    </form>
                <?php else : ?>
                    <a href="?page=login" class="btn-cart">
                        🔒 Login to buy
                    </a>
                <?php endif; ?>
            </div>
        <?php endwhile; ?>
    </div>

    <button class="slider-btn right" onclick="slideRight('offersSlider')">&#10095;</button>
</div>



<?php require "../app/views/layouts/footer.php"; ?>

