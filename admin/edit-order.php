<?php
require_once "auth.php";
require_once "../app/config/Database.php";

$db = new Database();
$conn = $db->connect();

if (!isset($_GET['id'])) {
    header("Location: orders.php");
    exit;
}
$id = (int)$_GET['id'];

$stmt = $conn->prepare("
    SELECT o.*, u.name
    FROM orders o
    JOIN users u ON u.id = o.user_id
    WHERE o.id = ?
");
$stmt->execute([$id]);
$order = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$order) {
    header("Location: orders.php");
    exit;
}

$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $status = $_POST['status'] ?? 'pending';
    $phone = trim($_POST['phone'] ?? '');
    $address = trim($_POST['address'] ?? '');

    $allowed = ['pending','processing','shipped','completed','cancelled'];
    if (!in_array($status, $allowed)) $status = 'pending';

    $upd = $conn->prepare("
        UPDATE orders
        SET status = :status, phone = :phone, address = :address
        WHERE id = :id
    ");
    $upd->execute([
        ':status' => $status,
        ':phone' => $phone,
        ':address' => $address,
        ':id' => $id
    ]);

    $message = "✅ Order updated!";

    // refresh
    $stmt->execute([$id]);
    $order = $stmt->fetch(PDO::FETCH_ASSOC);
}
?>

<h2>Edit Order #<?= (int)$order['id'] ?></h2>
<p>Customer: <b><?= htmlspecialchars($order['name']) ?></b></p>

<?php if ($message): ?>
    <p><?= htmlspecialchars($message) ?></p>
<?php endif; ?>

<form method="POST">
    <label>Status</label><br>
    <select name="status">
        <?php
        $statuses = ['pending','processing','shipped','completed','cancelled'];
        foreach ($statuses as $s) :
        ?>
            <option value="<?= $s ?>" <?= $order['status'] === $s ? 'selected' : '' ?>>
                <?= ucfirst($s) ?>
            </option>
        <?php endforeach; ?>
    </select>
    <br><br>

    <label>Phone</label><br>
    <input type="text" name="phone" value="<?= htmlspecialchars($order['phone'] ?? '') ?>">
    <br><br>

    <label>Address</label><br>
    <textarea name="address" rows="4"><?= htmlspecialchars($order['address'] ?? '') ?></textarea>
    <br><br>

    <button type="submit">💾 Save</button>
</form>

<br>
<a href="orders.php">⬅ Back to orders</a>
