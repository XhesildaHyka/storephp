<?php
require_once "auth.php";

require_once "../app/config/Database.php";

$title = $_POST['title'];
$subtitle = $_POST['subtitle'];

// Upload
$uploadDir = "../public/images/carousel/";

if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}

$imageName = uniqid() . "_" . basename($_FILES['image']['name']);
$target = $uploadDir . $imageName;

$allowed = ['jpg','jpeg','png','webp'];
$ext = strtolower(pathinfo($target, PATHINFO_EXTENSION));

if (!in_array($ext, $allowed)) {
    die("Invalid image type");
}

if (!move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
    die("Upload failed");
}

$imagePath = "carousel/" . $imageName;

// Save DB
$db = new Database();
$conn = $db->connect();

$stmt = $conn->prepare(
    "INSERT INTO banners (title, subtitle, image)
     VALUES (:title, :subtitle, :image)"
);

$stmt->execute([
    ':title' => $title,
    ':subtitle' => $subtitle,
    ':image' => $imagePath
]);

header("Location: banners.php");
exit;
