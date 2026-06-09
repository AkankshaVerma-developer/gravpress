<!------------ //not use this code anywhere right now --------------->
<?php 
session_start();
require_once "../connection/db.php";

$theme = $_GET['theme'];

// theme folder
$theme_path = "../user/view/themes/$theme/style.css";

if (isset($_POST['save'])) {
    file_put_contents($theme_path, $_POST['content']);
    $msg = "Theme updated successfully!";
}

$content = file_get_contents($theme_path);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Theme - <?php echo $theme; ?></title>
    <link rel="stylesheet" href="css/preview.css">
</head>
<body>

<div class="editor-box">
    <h2>Editing Theme: <?php echo $theme; ?></h2>

    <?php if (isset($msg)) echo "<p class='msg'>$msg</p>"; ?>

    <form method="post">
        <textarea name="content" class="editor"><?php echo $content; ?></textarea>
        <button type="submit" name="save" class="btn">Save Changes</button>
    </form>
</div>

</body>
</html>
