<?php
require_once "auth.php";
require_once "../app/config/Database.php";

$db = new Database();
$conn = $db->connect();

// count unread messages
$stmt = $conn->query("SELECT COUNT(*) AS total FROM contact_messages WHERE is_read = 0");
$unread = (int)$stmt->fetch(PDO::FETCH_ASSOC)['total'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>

    <style>
        .admin-link {
            text-decoration: none;
            font-weight: 600;
            color: #111;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .admin-badge {
            background: #ff3b3b;
            color: #fff;
            font-size: 12px;
            font-weight: 800;
            padding: 3px 8px;
            border-radius: 999px;
            line-height: 1;
        }
    </style>
</head>
<body>

<h1>Admin Dashboard</h1>

<p>Welcome, <?= htmlspecialchars($_SESSION['user']['name']) ?></p>

<p>
    <a href="messages.php" class="admin-link">
        📩 Messages
        <?php if ($unread > 0) : ?>
            <span class="admin-badge"><?= $unread ?></span>
        <?php endif; ?>
    </a>
</p>

<ul>
    <li><a href="products.php">Manage Products</a></li>
    <li><a href="banners.php">Manage Banners</a></li>
    <li><a href="/store-system/public/?page=logout">Logout</a></li>
    <li><a href="orders.php">📦 Orders</a></li>

</ul>

</body>
</html>
