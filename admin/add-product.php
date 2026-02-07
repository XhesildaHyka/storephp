<?php
require_once "auth.php";
require_once "../app/config/Database.php";

$db = new Database();
$conn = $db->connect();

$message = "";

$shoeSizes = array_map('strval', range(30, 46));  // 30..46

$clothesSizes = ['XS','S','M','L','XL'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (!isset($_FILES['image']) || $_FILES['image']['error'] !== 0) {
        $message = "Image upload failed";
    } else {

        $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
        $imageName = uniqid() . "." . $ext;
        $uploadPath = "../public/uploads/" . $imageName;

        if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadPath)) {

            $originalPrice = (float)$_POST['price'];
            $discount = isset($_POST['discount_percent']) ? (int)$_POST['discount_percent'] : 0;
            if ($discount < 0) $discount = 0;
            if ($discount > 90) $discount = 90;

            $newPrice = $originalPrice;
            if ($discount > 0) {
                $newPrice = $originalPrice * (1 - ($discount / 100));
            }

            $isOffer = isset($_POST['is_offer']) ? 1 : 0;
            if ($discount > 0) $isOffer = 1;

            $stmt = $conn->prepare("
                INSERT INTO products
                (name, description, material, price, original_price, discount_percent, category, gender, image, is_new, is_offer)
                VALUES
                (:name, :description, :material, :price, :original_price, :discount_percent, :category, :gender, :image, :is_new, :is_offer)
            ");

            $stmt->execute([
                ':name' => $_POST['name'],
                ':description' => $_POST['description'],
                ':material' => $_POST['material'] ?? null,
                ':price' => round($newPrice, 2),
                ':original_price' => $originalPrice,
                ':discount_percent' => $discount,
                ':category' => $_POST['category'],
                ':gender' => $_POST['gender'],
                ':image' => $imageName,
                ':is_new' => isset($_POST['is_new']) ? 1 : 0,
                ':is_offer' => $isOffer
            ]);

            $productId = (int)$conn->lastInsertId();

            // ✅ save sizes stock
            $category = $_POST['category'] ?? 'shoes';
            $sizesList = ($category === 'clothes') ? $clothesSizes : $shoeSizes;

            $ins = $conn->prepare("
                INSERT INTO product_sizes (product_id, size, stock)
                VALUES (:pid, :size, :stock)
                ON DUPLICATE KEY UPDATE stock = VALUES(stock)
            ");

            foreach ($sizesList as $sz) {
                $field = "stock_" . $sz;
                $stock = isset($_POST[$field]) ? (int)$_POST[$field] : 0;
                if ($stock < 0) $stock = 0;

                $ins->execute([
                    ':pid' => $productId,
                    ':size' => $sz,
                    ':stock' => $stock
                ]);
            }

            $message = "✅ Product added successfully (with size stock)!";
        } else {
            $message = "Failed to save image";
        }
    }
}
?>

<h2>Add Product</h2>

<?php if ($message): ?>
    <p><?= htmlspecialchars($message) ?></p>
<?php endif; ?>

<form method="POST" enctype="multipart/form-data">

    <input type="text" name="name" placeholder="Product name" required><br><br>

    <textarea name="description" placeholder="Description"></textarea><br><br>
    <input type="text" name="material" placeholder="Material (e.g. Leather, Cotton)"><br><br>


    <input type="number" step="0.01" name="price" placeholder="Original price" required><br><br>
    <input type="number" name="discount_percent" min="0" max="90" placeholder="Discount % (example 20)">
    <br><br>

    <select name="category" id="catSelect">
        <option value="shoes">Shoes</option>
        <option value="clothes">Clothes</option>
    </select><br><br>

    <select name="gender">
        <option value="men">Men</option>
        <option value="women">Women</option>
        <option value="kids">Kids</option>
    </select><br><br>

    <input type="file" name="image" required><br><br>

    <label><input type="checkbox" name="is_new"> New Arrival</label>
    <label><input type="checkbox" name="is_offer"> Offer</label>

    <hr>

    <h3>Stock per size</h3>
    <div id="shoeStock"
        style="
            display:grid;
            grid-template-columns: repeat(6, 1fr);
            gap: 12px;
            max-width: 900px;
            margin-top: 10px;
        ">

        <?php foreach ($shoeSizes as $sz): ?>
            <div style="display:flex;align-items:center;gap:8px;">
                <label style="width:32px;font-weight:600;">
                    <?= $sz ?>:
                </label>
                <input
                    type="number"
                    name="stock_<?= $sz ?>"
                    value="0"
                    min="0"
                    style="width:80px;padding:6px;"
                >
            </div>
        <?php endforeach; ?>

    </div>

    <div id="clothesStock" style="display:none;">
        <?php foreach ($clothesSizes as $sz): ?>
            <label><?= $sz ?>: </label>
            <input type="number" name="stock_<?= $sz ?>" value="0" min="0" style="width:90px;margin:6px;">
        <?php endforeach; ?>
    </div>

    <br><br>
    <button type="submit">Save Product</button>
</form>

<script>
const cat = document.getElementById('catSelect');
const shoe = document.getElementById('shoeStock');
const clothes = document.getElementById('clothesStock');

function toggleStock(){
  if(cat.value === 'clothes'){
    shoe.style.display = 'none';
    clothes.style.display = 'block';
  }else{
    shoe.style.display = 'block';
    clothes.style.display = 'none';
  }
}
cat.addEventListener('change', toggleStock);
toggleStock();
</script>

<br>
<a href="products.php">⬅ Back to products</a>
