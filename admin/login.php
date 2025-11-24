<?php
session_start();
require_once "../connection/db.php";

$msg = "";

if (isset($_POST['login'])) {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    $sql = "SELECT * FROM users WHERE email='$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        if (password_verify($password, $user['password'])) {

            // Correct session variables
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];

            header("Location: dashboard.php");
            exit;
        } else {
            $msg = "Invalid password!";
        }
    } else {
        $msg = "User not found!";
    }
}
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Login | GravPress</title>
  <link rel="stylesheet" href="login_register_fp.css">
</head>
<body class="auth">
  <div class="auth-box">
    <h2>Login</h2>
    <?php if($msg) echo "<p class='msg'>$msg</p>"; ?>
    
    <form method="post">
      <input type="email" name="email" placeholder="Email Address" required>
      <input type="password" name="password" placeholder="Password" required>

      <!-- FIXED BUTTON -->
      <button type="submit" name="login" class="button">Login</button>

      <p><a href="forget_password.php">Forgot Password?</a></p>
      <p>New here? <a href="register.php">Create account</a></p>
    </form>
  </div>
</body>
</html>
