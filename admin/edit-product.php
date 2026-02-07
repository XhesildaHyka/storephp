<?php
require_once "auth.php";
require_once "../app/config/Database.php";

$db = new Database();
$conn = $db->connect();

if (!isset($_GET['id'])) {
    header("Location: products.php");
    exit;
}

$id = (int)$_GET['id'];

// fetch product
$stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
$stmt->execute([$id]);
$product = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$product) {
    header("Location: products.php");
    exit;
}

// ✅ sizes arrays
$shoeSizes = array_map('strval', range(30, 46)); // 30..46
$clothesSizes = ['XS','S','M','L','XL'];

$message = "";

// fetch stock map for this product
$stockMap = [];
$st = $conn->prepare("SELECT size, stock FROM product_sizes WHERE product_id = ?");
$st->execute([$id]);
while ($r = $st->fetch(PDO::FETCH_ASSOC)) {
    $stockMap[(string)$r['size']] = (int)$r['stock'];
}

// update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $name = $_POST['name'] ?? '';
    $description = $_POST['description'] ?? '';
    $category = $_POST['category'] ?? 'shoes';
    $gender = $_POST['gender'] ?? 'men';

    // prices
    $originalPrice = (float)($_POST['original_price'] ?? ($product['original_price'] ?? $product['price']));
    if ($originalPrice < 0) $originalPrice = 0;

    $discount = isset($_POST['discount_percent']) ? (int)$_POST['discount_percent'] : 0;
    if ($discount < 0) $discount = 0;
    if ($discount > 90) $discount = 90;

    $isNew = isset($_POST['is_new']) ? 1 : 0;
    $isOffer = isset($_POST['is_offer']) ? 1 : 0;

    if ($isOffer === 0) {
        $discount = 0;
    }

    $newPrice = $originalPrice;
    if ($isOffer === 1 && $discount > 0) {
        $newPrice = $originalPrice * (1 - ($discount / 100));
    }
    $newPrice = round($newPrice, 2);

    // image
    $imageName = $product['image'];
    if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
        $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
        $newImageName = uniqid() . "." . $ext;
        $uploadPath = "../public/uploads/" . $newImageName;

        if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadPath)) {
            $oldPath = "../public/uploads/" . $imageName;
            if ($imageName && file_exists($oldPath)) unlink($oldPath);
            $imageName = $newImageName;
        }
    }

    // update product
    $update = $conn->prepare("
        UPDATE products SET
            name = :name,
            description = :description,
            material = :material,
            price = :price,
            original_price = :original_price,
            discount_percent = :discount_percent,
            category = :category,
            gender = :gender,
            image = :image,
            is_new = :is_new,
            is_offer = :is_offer
        WHERE id = :id
    ");

    $update->execute([
        ':name' => $name,
        ':description' => $description,
        ':material' => $_POST['material'] ?? null,
        ':price' => $newPrice,
        ':original_price' => $originalPrice,
        ':discount_percent' => $discount,
        ':category' => $category,
        ':gender' => $gender,
        ':image' => $imageName,
        ':is_new' => $isNew,
        ':is_offer' => $isOffer,
        ':id' => $id
    ]);

    // ✅ update stock per size (FIXED)
    $sizesList = ($category === 'clothes') ? $clothesSizes : $shoeSizes;

    // OPTIONAL: remove sizes that are not in this category (prevents junk sizes staying in DB)
    $placeholders = implode(',', array_fill(0, count($sizesList), '?'));
    $del = $conn->prepare("DELETE FROM product_sizes WHERE product_id = ? AND size NOT IN ($placeholders)");
    $del->execute(array_merge([$id], $sizesList));

    // ✅ UPSERT (insert or update)
    $up = $conn->prepare("
        INSERT INTO product_sizes (product_id, size, stock)
        VALUES (?, ?, ?)
        ON DUPLICATE KEY UPDATE stock = VALUES(stock)
    ");

    foreach ($sizesList as $sz) {
        $field = "stock_" . $sz;
        $stock = isset($_POST[$field]) ? (int)$_POST[$field] : 0;
        if ($stock < 0) $stock = 0;

        $up->execute([$id, (string)$sz, $stock]);
    }

    $message = "✅ Product updated (and stock saved)!";
    
    // refresh product
    $stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
    $stmt->execute([$id]);
    $product = $stmt->fetch(PDO::FETCH_ASSOC);

    // refresh stock map
    $stockMap = [];
    $st = $conn->prepare("SELECT size, stock FROM product_sizes WHERE product_id = ?");
    $st->execute([$id]);
    while ($r = $st->fetch(PDO::FETCH_ASSOC)) {
        $stockMap[(string)$r['size']] = (int)$r['stock'];
    }
}
?>

<style>
.stock-grid{
  display:flex;
  flex-wrap:wrap;
  gap:10px;
  margin-top:10px;
  max-width: 980px;
}
.stock-item{
  display:flex;
  align-items:center;
  gap:8px;
  padding:8px 10px;
  border:1px solid rgba(0,0,0,.15);
  border-radius:12px;
  background:#fff;
}
.stock-item label{
  font-weight:700;
  min-width:34px;
}
.stock-item input{
  width:90px;
  padding:6px 8px;
}
</style>

<h2>Edit Product</h2>

<?php if ($message): ?>
    <p><?= htmlspecialchars($message) ?></p>
<?php endif; ?>

<form method="POST" enctype="multipart/form-data">

    <input type="text" name="name" value="<?= htmlspecialchars($product['name']) ?>" required><br><br>

    <textarea name="description"><?= htmlspecialchars($product['description']) ?></textarea><br><br>
    <input type="text" name="material"
           value="<?= htmlspecialchars($product['material'] ?? '') ?>"
           placeholder="Material (e.g. Leather, Cotton)"><br><br>

    <label>Original price</label><br>
    <input type="number" step="0.01" name="original_price"
           value="<?= htmlspecialchars($product['original_price'] ?? $product['price']) ?>" required><br><br>

    <label>Discount %</label><br>
    <input type="number" name="discount_percent" min="0" max="90"
           value="<?= (int)($product['discount_percent'] ?? 0) ?>"><br><br>

    <label>Category</label><br>
    <select name="category">
        <option value="shoes" <?= $product['category'] === 'shoes' ? 'selected' : '' ?>>Shoes</option>
        <option value="clothes" <?= $product['category'] === 'clothes' ? 'selected' : '' ?>>Clothes</option>
    </select><br><br>

    <label>Gender</label><br>
    <select name="gender">
        <option value="men" <?= $product['gender'] === 'men' ? 'selected' : '' ?>>Men</option>
        <option value="women" <?= $product['gender'] === 'women' ? 'selected' : '' ?>>Women</option>
        <option value="kids" <?= $product['gender'] === 'kids' ? 'selected' : '' ?>>Kids</option>
    </select><br><br>

    <p>Current image:</p>
    <img src="/store-system/public/uploads/<?= htmlspecialchars($product['image']) ?>" width="120"><br><br>

    <label>Replace image (optional)</label><br>
    <input type="file" name="image"><br><br>

    <label><input type="checkbox" name="is_new" <?= !empty($product['is_new']) ? 'checked' : '' ?>> New Arrival</label>
    <label><input type="checkbox" name="is_offer" <?= !empty($product['is_offer']) ? 'checked' : '' ?>> Offer</label>

    <hr>

    <h3>Stock per size (<?= htmlspecialchars($product['category']) ?>)</h3>

    <?php $list = ($product['category'] === 'clothes') ? $clothesSizes : $shoeSizes; ?>

    <div class="stock-grid">
        <?php foreach ($list as $sz): $sz = (string)$sz; ?>
            <div class="stock-item">
                <label><?= htmlspecialchars($sz) ?>:</label>
                <input type="number"
                       name="stock_<?= htmlspecialchars($sz) ?>"
                       value="<?= (int)($stockMap[$sz] ?? 0) ?>"
                       min="0">
            </div>
        <?php endforeach; ?>
    </div>

    <br><br>
    <button type="submit">💾 Save Changes</button>
</form>

<br>
<a href="products.php">⬅ Back to products</a>
