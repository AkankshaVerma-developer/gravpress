<?php
require_once "../connection/db.php";

$msg = "";

if (isset($_POST['reset'])) {
    $email = trim($_POST['email']);
    $newpass = password_hash("123456", PASSWORD_BCRYPT);

    $sql = "UPDATE users SET password='$newpass' WHERE email='$email'";
    if ($conn->query($sql) && $conn->affected_rows > 0) {
        $msg = "Password reset successful! Your new password is <b>123456</b>";
    } else {
        $msg = "Email not found!";
    }
}
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Forgot Password | GravPress</title>
  <link rel="stylesheet" href="login_register_fp.css">
</head>
<body class="auth">
  <div class="auth-box">
    <h2>Forgot Password</h2>
    <?php if($msg) echo "<p class='msg'>$msg</p>"; ?>
    <form method="post">
      <input type="email" name="email" placeholder="Enter Registered Email" required>
      <button type="submit" name="reset">Reset Password</button>
      <p><a href="login.php">Back to Login</a></p>
    </form>
  </div>
</body>
</html>
