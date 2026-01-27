<?php
require_once "auth.php";
require_once "../app/config/Database.php";

$db = new Database();
$conn = $db->connect();

$stmt = $conn->query("SELECT * FROM products ORDER BY created_at DESC");
?>

<h2>Products</h2>
<a href="add-product.php">➕ Add Product</a>

<table border="1" cellpadding="10">
<tr>
    <th>Image</th>
    <th>Name</th>
    <th>Category</th>
    <th>Gender</th>
    <th>Price</th>
    <th>New</th>
    <th>Offer</th>
    <th>Actions</th>
</tr>


<?php while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) : ?>
<tr>
    <td>
        <img src="/store-system/public/uploads/<?= htmlspecialchars($row['image']) ?>" width="80">
    </td>
    <td><?= htmlspecialchars($row['name']) ?></td>
    <td><?= htmlspecialchars($row['category']) ?></td>
    <td><?= htmlspecialchars($row['gender']) ?></td>
    <td>$<?= number_format($row['price'], 2) ?></td>
    <td><?= $row['is_new'] ? '✔' : '' ?></td>
    <td><?= $row['is_offer'] ? '✔' : '' ?></td>

    <td>
        <a href="edit-product.php?id=<?= $row['id'] ?>">✏ Edit</a>
        |
        <a href="delete-product.php?id=<?= $row['id'] ?>"
            onclick="return confirm('Delete this product?')"
            style="color:red;">🗑 Delete</a>
    </td>

</tr>

<?php endwhile; ?>

</table>
