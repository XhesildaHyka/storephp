<?php require __DIR__ . '/../layouts/header.php'; ?>

<div class="category-page">

    <div class="category-hero">
        <div class="breadcrumb">
            <a href="?page=home">Home</a>
            <span>›</span>
            <a href="?page=category&cat=<?= urlencode($category) ?>&gen=<?= urlencode($gender) ?>">
                <?= htmlspecialchars(ucfirst($category)) ?>
            </a>
            <span>›</span>
            <span class="crumb-current"><?= htmlspecialchars(ucfirst($gender)) ?></span>
        </div>

        <div class="category-title-row">
            <h1><?= htmlspecialchars(ucfirst($category)) ?> <span>—</span> <?= htmlspecialchars(ucfirst($gender)) ?></h1>
            <div class="category-meta">
                <span><?= (int)$totalItems ?> items</span>
                <span class="dot">•</span>
                <span>Page <?= (int)$pageNum ?> / <?= (int)$totalPages ?></span>
            </div>
        </div>
    </div>

    <?php if (empty($items)) : ?>
        <div class="category-empty">
            <p>No products found in this category.</p>
            <a class="btn-primary" href="?page=home">Go back home</a>
        </div>
    <?php else : ?>

        <div class="category-grid">
            <?php foreach ($items as $row) : ?>
                <div class="cat-card">

                    <!-- ✅ LINK TO PRODUCT PAGE -->
                    <a class="cat-img" href="?page=product&id=<?= (int)$row['id'] ?>">
                        <img src="/store-system/public/uploads/<?= htmlspecialchars($row['image']) ?>"
                             alt="<?= htmlspecialchars($row['name']) ?>">

                        <?php if (!empty($row['is_new'])) : ?>
                            <span class="badge badge-new">NEW</span>
                        <?php endif; ?>

                        <?php if (!empty($row['is_offer']) && (int)($row['discount_percent'] ?? 0) > 0) : ?>
                            <span class="badge badge-offer">-<?= (int)$row['discount_percent'] ?>%</span>
                        <?php endif; ?>
                    </a>

                    <div class="cat-body">
                        <!-- ✅ LINK TO PRODUCT PAGE -->
                        <a href="?page=product&id=<?= (int)$row['id'] ?>" style="text-decoration:none;color:inherit;">
                            <h3 class="cat-name"><?= htmlspecialchars($row['name']) ?></h3>
                        </a>

                        <div class="cat-price-row">
                            <?php if (!empty($row['is_offer']) && (int)($row['discount_percent'] ?? 0) > 0) : ?>
                                <span class="price-old">
                                    $<?= number_format((float)($row['original_price'] ?? 0), 2) ?>
                                </span>
                                <span class="price-now">
                                    $<?= number_format((float)$row['price'], 2) ?>
                                </span>
                            <?php else : ?>
                                <span class="price-now">$<?= number_format((float)$row['price'], 2) ?></span>
                            <?php endif; ?>
                        </div>

                        <div class="cat-actions">
                            <!-- ✅ since size is required now -->
                            <a class="btn-primary btn-block" href="?page=product&id=<?= (int)$row['id'] ?>">
                                📏 Choose size
                            </a>
                        </div>
                    </div>

                </div>
            <?php endforeach; ?>
        </div>

        <!-- Pagination -->
        <?php if ($totalPages > 1) : ?>
            <div class="pagination">
                <?php
                    $base = "?page=category&cat=" . urlencode($category) . "&gen=" . urlencode($gender) . "&p=";
                ?>

                <a class="page-btn <?= $pageNum <= 1 ? 'disabled' : '' ?>"
                   href="<?= $pageNum <= 1 ? '#' : $base . ($pageNum - 1) ?>">← Prev</a>

                <div class="page-numbers">
                    <?php for ($i = 1; $i <= $totalPages; $i++) : ?>
                        <a class="page-num <?= $i == $pageNum ? 'active' : '' ?>"
                           href="<?= $base . $i ?>"><?= $i ?></a>
                    <?php endfor; ?>
                </div>

                <a class="page-btn <?= $pageNum >= $totalPages ? 'disabled' : '' ?>"
                   href="<?= $pageNum >= $totalPages ? '#' : $base . ($pageNum + 1) ?>">Next →</a>
            </div>
        <?php endif; ?>

    <?php endif; ?>

</div>

<?php require __DIR__ . '/../layouts/footer.php'; ?>
