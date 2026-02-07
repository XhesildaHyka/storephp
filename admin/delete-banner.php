<?php
require_once "auth.php";
require_once "../app/config/Database.php";

if (!isset($_GET['id'])) {
    header("Location: banners.php");
    exit;
}

$id = (int)$_GET['id'];

$db = new Database();
$conn = $db->connect();

$stmt = $conn->prepare("SELECT image FROM banners WHERE id = ?");
$stmt->execute([$id]);
$banner = $stmt->fetch(PDO::FETCH_ASSOC);

if ($banner) {
    // image is "carousel/xxx.jpg"
    $file = "../public/images/" . $banner['image'];
    if (file_exists($file)) {
        unlink($file);
    }

    $del = $conn->prepare("DELETE FROM banners WHERE id = ?");
    $del->execute([$id]);
}

header("Location: banners.php");
exit;
