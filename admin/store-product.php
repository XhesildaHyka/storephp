<?php
require_once "auth.php";


require_once "../app/config/Database.php";

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    die("Invalid request");
}

$name = $_POST['name'];
$description = $_POST['description'];
$price = $_POST['price'];
$category = $_POST['category'];
$gender = $_POST['gender'];
$is_new = isset($_POST['is_new']) ? 1 : 0;
$is_offer = isset($_POST['is_offer']) ? 1 : 0;

// IMAGE UPLOAD
$uploadDir = "../public/images/products/$category/";

if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}

$imageName = uniqid() . "_" . basename($_FILES['image']['name']);
$targetPath = $uploadDir . $imageName;

$imageType = strtolower(pathinfo($targetPath, PATHINFO_EXTENSION));
$allowed = ['jpg','jpeg','png','webp'];

if (!in_array($imageType, $allowed)) {
    die("Invalid image type");
}

if (!move_uploaded_file($_FILES['image']['tmp_name'], $targetPath)) {
    die("Image upload failed");
}

$imagePath = "products/$category/" . $imageName;

// SAVE TO DATABASE
$db = new Database();
$conn = $db->connect();

$sql = "INSERT INTO products 
(name, description, price, category, gender, is_new, is_offer, image)
VALUES 
(:name, :description, :price, :category, :gender, :is_new, :is_offer, :image)";

$stmt = $conn->prepare($sql);
$stmt->execute([
    ':name' => $name,
    ':description' => $description,
    ':price' => $price,
    ':category' => $category,
    ':gender' => $gender,
    ':is_new' => $is_new,
    ':is_offer' => $is_offer,
    ':image' => $imagePath
]);

header("Location: products.php");
exit;
