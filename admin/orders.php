<link rel="stylesheet" href="/store-system/public/css/style.css">

<?php
require_once "auth.php";
require_once "../app/config/Database.php";

$db = new Database();
$conn = $db->connect();

/* Handle status update */
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['order_id'])) {
    $stmt = $conn->prepare("UPDATE orders SET status = ? WHERE id = ?");
    $stmt->execute([$_POST['status'], $_POST['order_id']]);
}

/* Fetch orders */
$orders = $conn->query("
    SELECT o.*, u.name
    FROM orders o
    JOIN users u ON u.id = o.user_id
    ORDER BY o.created_at DESC
");
?>

<h2>📦 Orders</h2>

<table border="1" cellpadding="10">
<tr>
    <th>ID</th>
    <th>Customer</th>
    <th>Total</th>
    <th>Status</th>
    <th>Date</th>
    <th>Phone</th>
    <th>Address</th>
    <th>Actions</th>


</tr>

<?php while ($o = $orders->fetch(PDO::FETCH_ASSOC)) : ?>
<tr>
    <td>#<?= $o['id'] ?></td>
    <td><?= htmlspecialchars($o['name']) ?></td>
    <td>$<?= number_format($o['total'], 2) ?></td>

    <td>
        <form method="POST" style="display:inline;">
            <input type="hidden" name="order_id" value="<?= $o['id'] ?>">

            <select name="status" onchange="this.form.submit()">
                <?php
                $statuses = ['pending', 'processing', 'shipped', 'completed', 'cancelled'];
                foreach ($statuses as $s) :
                ?>
                    <option value="<?= $s ?>" <?= $o['status'] === $s ? 'selected' : '' ?>>
                        <?= ucfirst($s) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </form>
    </td>

    <td><?= $o['created_at'] ?></td>
    <td><?= htmlspecialchars($o['phone']) ?></td>
    <td><?= nl2br(htmlspecialchars($o['address'])) ?></td>
    <td>
        <a href="order-details.php?id=<?= (int)$o['id'] ?>">👁 View</a> |
        <a href="edit-order.php?id=<?= (int)$o['id'] ?>">✏ Edit</a> |
        <a href="delete-order.php?id=<?= (int)$o['id'] ?>"
           onclick="return confirm('Delete this order?')"
           style="color:red;">🗑 Delete</a>

    </td>



</tr>
<?php endwhile; ?>
</table>
