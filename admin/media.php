<?php

// CREATE UPLOAD FOLDER IF NOT EXISTS
if (!is_dir("uploads")) {
    mkdir("uploads", 0777, true);
}

// DELETE FILE
if (isset($_GET['delete'])) {
    $delFile = "uploads/" . basename($_GET['delete']);
    if (file_exists($delFile)) {
        unlink($delFile);
    }
    header("Location: media.php");
    exit;
}

// UPLOAD FILES
if (isset($_POST['upload'])) {
    foreach ($_FILES['files']['tmp_name'] as $key => $tmp) {
        $fileName = basename($_FILES['files']['name'][$key]);
        $targetPath = "uploads/" . $fileName;
        move_uploaded_file($tmp, $targetPath);
    }
    header("Location: media.php");
    exit;
}

// SEARCH
$search = "";
if (isset($_GET['search'])) {
    $search = strtolower($_GET['search']);
}

// GET ALL FILES
$files = array_diff(scandir("uploads"), ['.', '..']);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Media Library - GravPress</title>
    <link rel="stylesheet" href="media.css">
</head>

<body>

<h1 class="title">Media Library</h1>

<!-- UPLOAD FORM -->
<div class="upload-section">
    <form method="POST" enctype="multipart/form-data">
        <input type="file" name="files[]" multiple required>
        <button type="submit" name="upload" class="btn">Upload Files</button>
    </form>
</div>

<!-- SEARCH BAR -->
<form method="GET" class="search-box">
    <input type="text" name="search" placeholder="Search images (toy, cloud…)" value="<?= $search ?>">
    <button class="btn">Search</button>
</form>

<!-- MEDIA GRID -->
<div class="media-grid">

<?php
foreach ($files as $file):
    if ($search && strpos(strtolower($file), $search) === false) continue;
?>

    <div class="media-card">
        <img src="uploads/<?= $file ?>" alt="">
        <div class="media-info">
            <p><?= $file ?></p>
            <a href="?delete=<?= $file ?>" class="delete-btn"
               onclick="return confirm('Delete this image?')">Delete</a>
        </div>
    </div>

<?php endforeach; ?>

</div>

</body>
</html>
