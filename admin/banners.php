<?php
require_once "auth.php";
require_once "../app/config/Database.php";

$db = new Database();
$conn = $db->connect();

$banners = $conn->query("SELECT * FROM banners ORDER BY created_at DESC");
?>

<h2>Carousel Banners</h2>
<a href="add-banner.php">➕ Add Banner</a>

<table border="1" cellpadding="10">
<tr>
    <th>Image</th>
    <th>Title</th>
    <th>Subtitle</th>
    <th>Status</th>
    <th>Actions</th>
</tr>

<?php while ($b = $banners->fetch(PDO::FETCH_ASSOC)) : ?>
<tr>
    <td>
        <!-- image stored as "carousel/xxx.jpg" -->
        <img src="/store-system/public/images/<?= htmlspecialchars($b['image']) ?>" width="160">
    </td>

    <td><?= htmlspecialchars($b['title'] ?? '') ?></td>
    <td><?= htmlspecialchars($b['subtitle'] ?? '') ?></td>
    <td><?= !empty($b['is_active']) ? 'Active' : 'Hidden' ?></td>

    <td>
        <a href="edit-banner.php?id=<?= (int)$b['id'] ?>">✏ Edit</a> |
        <a href="delete-banner.php?id=<?= (int)$b['id'] ?>"
           onclick="return confirm('Delete this banner?')"
           style="color:red;">🗑 Delete</a>
    </td>
</tr>
<?php endwhile; ?>
</table>
