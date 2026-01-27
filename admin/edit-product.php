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

$message = "";

// update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $name = $_POST['name'] ?? '';
    $description = $_POST['description'] ?? '';
    $category = $_POST['category'] ?? 'shoes';
    $gender = $_POST['gender'] ?? 'men';

    // prices
    $originalPrice = (float)($_POST['original_price'] ?? $product['original_price'] ?? $product['price']);
    $discount = (int)($_POST['discount_percent'] ?? 0);
    if ($discount < 0) $discount = 0;
    if ($discount > 90) $discount = 90;

    $newPrice = $originalPrice;
    if ($discount > 0) {
        $newPrice = $originalPrice * (1 - ($discount / 100));
    }

    $isNew = isset($_POST['is_new']) ? 1 : 0;
    $isOffer = isset($_POST['is_offer']) ? 1 : 0;
    if ($discount > 0) $isOffer = 1;

    // image handling
    $imageName = $product['image'];

    if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
        $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
        $newImageName = uniqid() . "." . $ext;
        $uploadPath = "../public/uploads/" . $newImageName;

        if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadPath)) {
            // delete old image file
            $oldPath = "../public/uploads/" . $imageName;
            if ($imageName && file_exists($oldPath)) {
                unlink($oldPath);
            }
            $imageName = $newImageName;
        }
    }

    $update = $conn->prepare("
        UPDATE products SET
            name = :name,
            description = :description,
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

    $message = "✅ Product updated!";

    // refresh product data for display
    $stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
    $stmt->execute([$id]);
    $product = $stmt->fetch(PDO::FETCH_ASSOC);
}
?>

<h2>Edit Product</h2>

<?php if ($message): ?>
    <p><?= htmlspecialchars($message) ?></p>
<?php endif; ?>

<form method="POST" enctype="multipart/form-data">

    <input type="text" name="name" value="<?= htmlspecialchars($product['name']) ?>" required><br><br>

    <textarea name="description"><?= htmlspecialchars($product['description']) ?></textarea><br><br>

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

    <br><br>
    <button type="submit">💾 Save Changes</button>
</form>

<br>
<a href="products.php">⬅ Back to products</a>
