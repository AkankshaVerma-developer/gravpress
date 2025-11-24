<?php
require_once "../connection/db.php";

$msg = "";

if (isset($_POST['register'])) {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $pass = password_hash($_POST['password'], PASSWORD_BCRYPT);

    $check = $conn->query("SELECT * FROM users WHERE email='$email'");
    if ($check->num_rows > 0) {
        $msg = "Email already registered!";
    } else {
        $sql = "INSERT INTO users (name, email, password) VALUES ('$name', '$email', '$pass')";
        if ($conn->query($sql)) {
            $msg = "Registration successful! <a href='login.php'>Login here</a>";
        } else {
            $msg = "Error: " . $conn->error;
        }
    }
}
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Register-GravPress</title>
  <link rel="stylesheet" href="login_register_fp.css">
</head>
<body class="auth">
  <div class="auth-box">
    <h2>Create Account</h2>
    <?php if($msg) echo "<p class='msg'>$msg</p>"; ?>
    <form method="post">
      <input type="text" name="name" placeholder="Full Name" required>
      <input type="email" name="email" placeholder="Email Address" required>
      <input type="password" name="password" placeholder="Password" required>
     
      <button type="submit" name="register" class="button"> 
        <a href="login.php" name="register" class="registerbutton">Register</a>
      </button>

      
      <p>Already have an account? <a href="login.php">Login</a></p>
    </form>
  </div>
</body>
</html>
