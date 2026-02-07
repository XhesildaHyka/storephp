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

$stmt = $conn->prepare("DELETE FROM contact_messages WHERE id = ?");
$stmt->execute([$id]);

header("Location: messages.php");
exit;
