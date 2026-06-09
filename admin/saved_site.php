<?php
session_start();
require_once "../connection/db.php";

$user_id = $_SESSION['user_id'];

$res = $conn->query("SELECT * FROM saved_sites WHERE user_id = $user_id ORDER BY id DESC");
?>
<!DOCTYPE html>
<html>
<head>
<title>My Saved Websites</title>
<style>
body {
    font-family: Arial;
    padding: 20px;
}

h2 {
    margin-bottom: 20px;
}

.site-card {
    width: 320px;
    display: inline-block;
    padding: 15px;
    margin: 10px;
    border: 1px solid #ddd;
    border-radius: 12px;
    box-shadow: 0 3px 8px rgba(0,0,0,0.1);
    vertical-align: top;
}

.site-card h3 {
    margin-bottom: 10px;
}

.btn-view {
    background: #007bff;
    padding: 8px 14px;
    color: #fff;
    text-decoration: none;
    border-radius: 6px;
}

.empty-box {
    background: #f8f8f8;
    padding: 40px;
    border: 1px dashed #bbb;
    text-align: center;
    border-radius: 10px;
    width: 100%;
    margin-top: 30px;
}
.btn-delete {
    background: #dc3545;
    padding: 8px 14px;
    color: #fff;
    text-decoration: none;
    border-radius: 6px;
    margin-left:120px;
}
</style>
</head>
<body>

<h2>Your Saved Websites</h2>

<?php if ($res->num_rows == 0) {} ?>

<div class="empty-box">
    <h3>No saved websites yet</h3>
    <p>Save a site from the editor to see it here.</p>
</div>

<?php while($row = $res->fetch_assoc()) { 
    $folder = basename($row['folder_path']);
?>
<div class="site-card">
    <h3><?php echo $row['site_name']; ?></h3>
    <p><b>Created:</b> <?php echo $row['created_at']; ?></p>
    
    <a class="btn-view" 
       href="../sites/saved/<?php echo $folder; ?>/home.php" 
       target="_blank">
       View Website
    </a>
    <!-- Delete Button -->
    <!-- <a class="btn-delete"
       href="delete_site.php?id=""
       onclick="return confirm('Are you sure you want to delete this site?');">
       Delete
    </a> -->
</div>
<?php } ?>


<?php  ?>
<?php
// CREATE FOLDER IF NOT EXISTS
$folder = "saved_site/";
if (!is_dir($folder)) {
    mkdir($folder, 0777, true);
}

// GET HTML CONTENT
$content = $_POST['content'] ?? '';

if (empty($content)) {
    echo " Nothing to save!";
    exit;
}

// GENERATE FILE NAME
$filename = $folder . "website_" . time() . ".html";

// SAVE FILE
file_put_contents($filename, $content);

echo "✅ Website Saved Successfully! File: " . basename($filename);
?>

</body>
</html>
