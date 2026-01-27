<?php
require_once "auth.php";
require_once "../app/config/Database.php";

$db = new Database();
$conn = $db->connect();

$message = "";

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

        // if discount exists, treat as offer automatically (optional but recommended)
        $isOffer = isset($_POST['is_offer']) ? 1 : 0;
        if ($discount > 0) $isOffer = 1;

        $stmt = $conn->prepare("
            INSERT INTO products
            (name, description, price, original_price, discount_percent, category, gender, image, is_new, is_offer)
            VALUES
            (:name, :description, :price, :original_price, :discount_percent, :category, :gender, :image, :is_new, :is_offer)
        ");

        $stmt->execute([
            ':name' => $_POST['name'],
            ':description' => $_POST['description'],
            ':price' => $newPrice,                 // ✅ discounted price saved as current price
            ':original_price' => $originalPrice,   // ✅ original price saved
            ':discount_percent' => $discount,
            ':category' => $_POST['category'],
            ':gender' => $_POST['gender'],
            ':image' => $imageName,
            ':is_new' => isset($_POST['is_new']) ? 1 : 0,
            ':is_offer' => $isOffer
        ]);


            $message = "Product added successfully!";
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

    <input type="number" step="0.01" name="price" placeholder="Price" required><br><br>
    <input type="number" name="discount_percent" min="0" max="90" placeholder="Discount % (example 20)">
    <br><br>

    <select name="category">
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

    <br><br>
    <button type="submit">Save Product</button>
</form>

<br>
<a href="products.php">⬅ Back to products</a>
