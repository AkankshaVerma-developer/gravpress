<?php
session_start();
require_once '../partials/db.php';

// If already logged in, go to dashboard
if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
    header("Location: dashboard.php");
    exit();
}

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get and trim inputs
    $username = isset($_POST['username']) ? trim($_POST['username']) : '';
    $new_password = isset($_POST['new_password']) ? trim($_POST['new_password']) : '';

    // Basic validation
    if ($username === '' || $new_password === '') {
        $error = 'All fields are required.';
    } elseif (strlen($new_password) < 6) {
        $error = 'Password should be at least 6 characters.';
    } else {
        // Check user exists
        $stmt = $conn->prepare("SELECT id FROM admins WHERE username = ?");
        if (!$stmt) {
            $error = "SQL error: " . $conn->error;
        } else {
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows === 0) {
                $error = 'User not found.';
            } else {
                $user = $result->fetch_assoc();
                $user_id = $user['id'];

                // Hash new password and update DB
                $new_hash = password_hash($new_password, PASSWORD_DEFAULT);

                $update = $conn->prepare("UPDATE admins SET password_hash = ? WHERE id = ?");
                if (!$update) {
                    $error = "SQL error: " . $conn->error;
                } else {
                    $update->bind_param("si", $new_hash, $user_id);
                    if ($update->execute()) {
                        // Redirect to login page with a success
                        header("Location: login.php?reset=success");
                        exit();
                    } else {
                        $error = 'Failed to update password. Please try again later.';
                    }
                }
            }
            $stmt->close();
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Reset Password</title>
  <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

<div class="login-container">
  <div class="login-box">
    <h2>Reset Password</h2>

    <?php if ($error): ?>
      <p style="color: red; font-weight:600;"><?php echo htmlspecialchars($error); ?></p>
    <?php endif; ?>

    <?php if ($success): ?>
      <p style="color: green; font-weight:600;"><?php echo htmlspecialchars($success); ?></p>
    <?php endif; ?>

    <form method="POST" novalidate>
      <input type="text" name="username" placeholder="Enter Username" required value="<?php echo isset($username) ? htmlspecialchars($username) : ''; ?>">

      <input type="password" name="new_password" placeholder="New Password" required>

      <button type="submit" class="btn">Reset Password</button>

      <div class="forgot-password">
        <a href="login.php">Back to Login</a>
      </div>
    </form>
  </div>
</div>

</body>
</html>
