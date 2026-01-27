<?php
require_once "auth.php";
require_once "../app/config/Database.php";

if (!isset($_GET['id'])) {
    header("Location: products.php");
    exit;
}

$id = (int) $_GET['id'];

$db = new Database();
$conn = $db->connect();

/* Get image name */
$stmt = $conn->prepare("SELECT image FROM products WHERE id = ?");
$stmt->execute([$id]);
$product = $stmt->fetch(PDO::FETCH_ASSOC);

if ($product) {

    /* Delete image from folder */
    $imagePath = "../public/uploads/" . $product['image'];
    if (file_exists($imagePath)) {
        unlink($imagePath);
    }

    /* Delete product from DB */
    $stmt = $conn->prepare("DELETE FROM products WHERE id = ?");
    $stmt->execute([$id]);
}

header("Location: products.php");
exit;
