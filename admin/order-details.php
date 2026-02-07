<?php
require_once "auth.php";
require_once "../app/config/Database.php";

$db = new Database();
$conn = $db->connect();

if (!isset($_GET['id'])) {
    header("Location: orders.php");
    exit;
}

$orderId = (int)$_GET['id'];

// Order info
$stmt = $conn->prepare("
    SELECT o.*, u.name, u.email
    FROM orders o
    JOIN users u ON u.id = o.user_id
    WHERE o.id = ?
");
$stmt->execute([$orderId]);
$order = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$order) {
    header("Location: orders.php");
    exit;
}

// Items in order
$items = $conn->prepare("
    SELECT oi.*, p.name, p.image
    FROM order_items oi
    JOIN products p ON p.id = oi.product_id
    WHERE oi.order_id = ?
");
$items->execute([$orderId]);

$grand = 0;
?>

<h2>📦 Order #<?= (int)$order['id'] ?></h2>

<p><b>Customer:</b> <?= htmlspecialchars($order['name']) ?> (<?= htmlspecialchars($order['email']) ?>)</p>
<p><b>Status:</b> <?= htmlspecialchars($order['status']) ?></p>
<p><b>Date:</b> <?= htmlspecialchars($order['created_at']) ?></p>
<p><b>Phone:</b> <?= htmlspecialchars($order['phone'] ?? '-') ?></p>
<p><b>Address:</b><br><?= nl2br(htmlspecialchars($order['address'] ?? '-')) ?></p>

<hr>

<h3>🛒 Products</h3>

<table border="1" cellpadding="10">
<tr>
    <th>Image</th>
    <th>Product</th>
    <th>Price</th>
    <th>Qty</th>
    <th>Total</th>
</tr>

<?php while ($row = $items->fetch(PDO::FETCH_ASSOC)) : ?>
    <?php
        $line = $row['price'] * $row['quantity'];
        $grand += $line;
    ?>
    <tr>
        <td>
            <img src="/store-system/public/uploads/<?= htmlspecialchars($row['image']) ?>" width="70">
        </td>
        <td><?= htmlspecialchars($row['name']) ?></td>
        <td>$<?= number_format($row['price'], 2) ?></td>
        <td><?= (int)$row['quantity'] ?></td>
        <td>$<?= number_format($line, 2) ?></td>
    </tr>
<?php endwhile; ?>

<tr>
    <td colspan="4" style="text-align:right;"><b>Grand Total</b></td>
    <td><b>$<?= number_format($grand, 2) ?></b></td>
</tr>
</table>

<br>
<a href="orders.php">⬅ Back to Orders</a>
