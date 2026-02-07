<?php
require_once "auth.php";
require_once "../app/config/Database.php";

$db = new Database();
$conn = $db->connect();

if (!isset($_GET['id'])) {
    header("Location: banners.php");
    exit;
}

$id = (int)$_GET['id'];

$stmt = $conn->prepare("SELECT * FROM banners WHERE id = ?");
$stmt->execute([$id]);
$banner = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$banner) {
    header("Location: banners.php");
    exit;
}

$message = "";

// folder where banners are stored
$bannerDir = "../public/images/carousel/";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $title = trim($_POST['title'] ?? '');
    $subtitle = trim($_POST['subtitle'] ?? '');
    $isActive = isset($_POST['is_active']) ? 1 : 0;

    // keep old image path by default (ex: carousel/abc.jpg)
    $imagePath = $banner['image'];

    // upload new image if provided
    if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {

        if (!is_dir($bannerDir)) {
            mkdir($bannerDir, 0777, true);
        }

        $allowed = ['jpg','jpeg','png','webp'];
        $ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));

        if (!in_array($ext, $allowed)) {
            $message = "❌ Invalid image type (jpg, png, webp only).";
        } else {
            $newName = uniqid() . "_" . basename($_FILES['image']['name']);
            $target = $bannerDir . $newName;

            if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {

                // delete old file
                $oldFile = "../public/images/" . $banner['image']; // includes carousel/...
                if (!empty($banner['image']) && file_exists($oldFile)) {
                    unlink($oldFile);
                }

                // save as "carousel/filename"
                $imagePath = "carousel/" . $newName;
            } else {
                $message = "❌ Upload failed.";
            }
        }
    }

    if ($message === "") {
        $update = $conn->prepare("
            UPDATE banners SET
                title = :title,
                subtitle = :subtitle,
                image = :image,
                is_active = :is_active
            WHERE id = :id
        ");

        $update->execute([
            ':title' => $title,
            ':subtitle' => $subtitle,
            ':image' => $imagePath,
            ':is_active' => $isActive,
            ':id' => $id
        ]);

        $message = "✅ Banner updated!";

        // refresh
        $stmt = $conn->prepare("SELECT * FROM banners WHERE id = ?");
        $stmt->execute([$id]);
        $banner = $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>

<h2>Edit Banner</h2>

<?php if ($message) : ?>
    <p><?= htmlspecialchars($message) ?></p>
<?php endif; ?>

<form method="POST" enctype="multipart/form-data">

    <label>Title</label><br>
    <input type="text" name="title" value="<?= htmlspecialchars($banner['title'] ?? '') ?>"><br><br>

    <label>Subtitle</label><br>
    <input type="text" name="subtitle" value="<?= htmlspecialchars($banner['subtitle'] ?? '') ?>"><br><br>

    <p>Current image:</p>
    <img src="/store-system/public/images/<?= htmlspecialchars($banner['image']) ?>" width="260"><br><br>

    <label>Replace image (optional)</label><br>
    <input type="file" name="image"><br><br>

    <label>
        <input type="checkbox" name="is_active" <?= !empty($banner['is_active']) ? 'checked' : '' ?>>
        Active
    </label>

    <br><br>
    <button type="submit">💾 Save Changes</button>
</form>

<br>
<a href="banners.php">⬅ Back to banners</a>
