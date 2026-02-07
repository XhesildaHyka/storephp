<?php
require_once "auth.php";
require_once "../app/config/Database.php";

if (!isset($_GET['id'])) {
    header("Location: orders.php");
    exit;
}

$id = (int)$_GET['id'];

$db = new Database();
$conn = $db->connect();

// delete items first
$stmt = $conn->prepare("DELETE FROM order_items WHERE order_id = ?");
$stmt->execute([$id]);

// then delete order
$stmt = $conn->prepare("DELETE FROM orders WHERE id = ?");
$stmt->execute([$id]);

header("Location: orders.php");
exit;
