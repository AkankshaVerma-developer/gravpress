<?php
session_start();
require_once "../connection/db.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch existing settings
$q = $conn->query("SELECT * FROM user_settings WHERE user_id=$user_id");
$settings = $q->fetch_assoc();

// Default values if empty
$full_name = $settings['full_name'] ?? "";
$email = $settings['email'] ?? "";
$profile_pic = $settings['profile_pic'] ?? "default.png";
$bio = $settings['bio'] ?? "";
$timezone = $settings['timezone'] ?? "Asia/Kolkata";

// On Save
if (isset($_POST['save'])) {

    $full_name = $_POST['full_name'];
    $email = $_POST['email'];
    $bio = $_POST['bio'];
    $timezone = $_POST['timezone'];
   
    // Upload profile pic
    if (!empty($_FILES['profile_pic']['name'])) {
        $file = $_FILES['profile_pic']['name'];
        $path =  basename($file);
        move_uploaded_file($_FILES['profile_pic']['tmp_name'], $path);
        $profile_pic = $path;
    }

    // Insert or update
    if ($settings) {
        $sql = "UPDATE user_settings 
                SET full_name='$full_name', email='$email', profile_pic='$profile_pic',
                    bio='$bio', timezone='$timezone'
                WHERE user_id=$user_id";
    } else {
        $sql = "INSERT INTO user_settings 
                (user_id, full_name, email, profile_pic, bio, timezone)
                VALUES ($user_id, '$full_name', '$email', '$profile_pic', '$bio', '$timezone')";
    }
    
    $conn->query($sql);
    $msg = "Settings saved successfully!";
}
?>
<!DOCTYPE html>
<html>
<head>
<title> Settings</title>
<link rel="stylesheet" href="account_settings.css">
</head>

<body>

<div class="settings-container">


    <?php if (isset($msg)) echo "<p class='msg'>$msg</p>"; ?>

    <form method="POST" enctype="multipart/form-data">

        <label>Full Name</label>
        <input type="text" name="full_name" value="<?php echo $full_name; ?>" required>

        <label>Email Address</label>
        <input type="email" name="email" value="<?php echo $email; ?>" required>

        <label>Profile Picture</label>
        <input type="file" name="profile_pic">
        <img src="<?php echo $profile_pic; ?>" class="preview">

        <label>Bio</label>
        <textarea name="bio" rows="4"><?php echo $bio; ?></textarea>

        <label>Timezone</label>
        <select name="timezone">
            <option value="Asia/Kolkata" <?php if($timezone=="Asia/Kolkata") echo "selected"; ?>>Asia/Kolkata</option>
            <option value="UTC" <?php if($timezone=="UTC") echo "selected"; ?>>UTC</option>
            <option value="America/New_York" <?php if($timezone=="America/New_York") echo "selected"; ?>>America/New_York</option>
        </select>

       

        <button type="submit" name="save" class="btn-save">Save Settings</button>

    </form>
</div>

</body>
</html>
