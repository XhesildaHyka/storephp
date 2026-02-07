<?php
require_once "auth.php";
require_once "../app/config/Database.php";

if (!isset($_GET['id'])) {
    header("Location: messages.php");
    exit;
}

$id = (int)$_GET['id'];

$db = new Database();
$conn = $db->connect();

$stmt = $conn->prepare("UPDATE contact_messages SET is_read = 1 WHERE id = ?");
$stmt->execute([$id]);

header("Location: messages.php");
exit;
