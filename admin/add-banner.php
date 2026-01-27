<?php
require_once "auth.php";?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Banner</title>
</head>
<body>

<h2>Add Carousel Banner</h2>

<form action="store-banner.php" method="POST" enctype="multipart/form-data">

    <input type="text" name="title" placeholder="Title" required><br><br>

    <input type="text" name="subtitle" placeholder="Subtitle"><br><br>

    <input type="file" name="image" required><br><br>

    <button type="submit">Add Banner</button>

</form>

</body>
</html>
