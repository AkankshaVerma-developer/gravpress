<?php
session_start();
require_once "../connection/db.php";

$user_id = $_SESSION['user_id'];
// THIS IS THE REAL EDITABLE COPY (persistent)
$webCopy = realpath("../sites/{$user_id}_theme-ecommerce_copy");

if (!$webCopy) {
    die("Editing copy not found. Please create a copy first.");
}

// $source = realpath("../sites/{$user_id}_theme-ecommerce_copy");


// if (!$source) {
//     echo "Editing copy not found.";
//     exit;
// }

// $destinationDir = "../sites/saved/site_" . time();
// mkdir($destinationDir, 0777, true);

// // copy folder
// function copyFolder($src, $dest) {
//     $dir = opendir($src);
//     @mkdir($dest);

//     while(false !== ($file = readdir($dir))) {
//         if (($file != '.') && ($file != '..')) {
//             if (is_dir($src . '/' . $file)) {
//                 copyFolder($src . '/' . $file, $dest . '/' . $file);
//             } else {
//                 copy($src . '/' . $file, $dest . '/' . $file);
//             }
//         }
//     }
//     closedir($dir);
// }

// copyFolder($source, $destinationDir);

// INSERT into database
$siteName = "My Website " . date("d M Y, h:i A");

$stmt = $conn->prepare("INSERT INTO saved_sites (user_id, site_name, folder_path) VALUES (?,?,?)");
$stmt->bind_param("iss", $user_id, $siteName, $destinationDir);
$stmt->execute();

echo "Website saved successfully!";
?>
