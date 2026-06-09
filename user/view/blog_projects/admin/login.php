<?php
session_start();
require_once '../partials/db.php';

// If already logged in, go directly to dashboard
if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
    header("Location:dashboard.php");
    exit();
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    $stmt = $conn->prepare("SELECT * FROM admins WHERE username = ?");
    if (!$stmt) {
        die("SQL Error: " . $conn->error);
    }
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        // Your DB column is 'password_hash'
        if (password_verify($password, $user['password_hash'])) {
            $_SESSION['admin_logged_in'] = true;
            $_SESSION['admin_name'] = $user['username'];
            $_SESSION['admin_id'] = $user['id'];
            header("Location: dashboard.php");
            exit();
        } else {
            $error = "Invalid password.";
        }
    } else {
        $error = "User not found.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Admin Login</title>
  <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

<div class="login-container">
  <div class="login-box">
    <h2>Admin Login</h2>

    <?php if ($error): ?>
      <p style="color: red; font-weight:600;"><?php echo $error; ?></p>
    <?php endif; ?>

    <form method="POST">
      <input type="text" name="username" placeholder="Enter Username" required>
      <input type="password" name="password" placeholder="Enter Password" required>
      <button type="submit" class="btn">Login</button>

      <!-- Added Forgot Password link  -->
      <div class="forgot-password">
        <a href="forgot_password.php">Forgot Password?</a>
      </div>
    </form>
  </div>
</div>

</body>
</html>
