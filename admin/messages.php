<?php
require_once "auth.php";
require_once "../app/config/Database.php";

$db = new Database();
$conn = $db->connect();

$stmt = $conn->query("SELECT * FROM contact_messages ORDER BY created_at DESC");
?>

<h2>📩 Contact Messages</h2>

<table border="1" cellpadding="10" cellspacing="0">
    <tr>
        <th>Date</th>
        <th>Name</th>
        <th>Email</th>
        <th>Subject</th>
        <th>Message</th>
        <th>Status</th>
        <th>Action</th>
    </tr>

    <?php while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) : ?>
        <tr>
            <td><?= htmlspecialchars($row['created_at']) ?></td>
            <td><?= htmlspecialchars($row['name']) ?></td>
            <td><?= htmlspecialchars($row['email']) ?></td>
            <td><?= htmlspecialchars($row['subject']) ?></td>
            <td style="max-width:350px;">
                <?= nl2br(htmlspecialchars($row['message'])) ?>
            </td>
            <td><?= $row['is_read'] ? "Read" : "New" ?></td>
            <td>
                <a href="mark-read.php?id=<?= (int)$row['id'] ?>">✅ Mark read</a>
                |
                <a href="delete-message.php?id=<?= (int)$row['id'] ?>"
                   onclick="return confirm('Delete this message?')"
                   style="color:red;">🗑 Delete</a>
            </td>
        </tr>
    <?php endwhile; ?>
</table>
