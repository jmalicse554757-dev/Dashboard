<?php
session_start();

// Already logged in → go to dashboard
if (isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}

include "db.php";

$error   = "";
$success = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    $confirm  = $_POST['confirm_password'];

    // Validation
    if ($username == "" || $password == "") {
        $error = "Username and password are required!";
    } elseif (strlen($username) < 3) {
        $error = "Username must be at least 3 characters.";
    } elseif (strlen($password) < 6) {
        $error = "Password must be at least 6 characters.";
    } elseif ($password !== $confirm) {
        $error = "Passwords do not match!";
    } else {
        // Check if username already exists
        $check = mysqli_query($conn, "SELECT user_id FROM users WHERE username='$username'");

        if (mysqli_num_rows($check) > 0) {
            $error = "Username already taken. Please choose another.";
        } else {
            // Hash the password before saving
            $hashed = password_hash($password, PASSWORD_DEFAULT);

            mysqli_query($conn, "INSERT INTO users (username, password) VALUES ('$username', '$hashed')");

            $success = "Account created! You can now log in.";
        }
    }
}
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Register — Service Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
  <link href="https://fonts.googleapis.com/css2?family=Syne:wght@600;700;800&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="style.css">
</head>
<body>

  <div class="login-wrap">
    <div class="login-card">

      <!-- Logo -->
      <div class="login-logo">
        <i class="bi bi-grid-3x3-gap-fill"></i>
        <span class="login-brand">Service<span>Dash</span></span>
      </div>

      <h2 class="login-title">Create account</h2>
      <p class="login-sub">Register to access the dashboard</p>

      <!-- Alerts -->
      <?php if ($error): ?>
        <div class="alert-error mb-4">
          <i class="bi bi-exclamation-triangle-fill me-2"></i><?php echo $error; ?>
        </div>
      <?php endif; ?>

      <?php if ($success): ?>
        <div class="alert-success mb-4">
          <i class="bi bi-check-circle-fill me-2"></i><?php echo $success; ?>
        </div>
      <?php endif; ?>

      <!-- Form -->
      <form method="POST" autocomplete="off">

        <div class="form-group mb-3">
          <label class="form-label-custom">
            <i class="bi bi-person-fill"></i> Username
          </label>
          <input type="text" name="username" class="input-custom"
                 placeholder="Choose a username" required
                 value="<?php echo isset($_POST['username']) ? htmlspecialchars($_POST['username']) : ''; ?>">
        </div>

        <div class="form-group mb-3">
          <label class="form-label-custom">
            <i class="bi bi-lock-fill"></i> Password
          </label>
          <input type="password" name="password" class="input-custom"
                 placeholder="At least 6 characters" required>
        </div>

        <div class="form-group mb-4">
          <label class="form-label-custom">
            <i class="bi bi-lock-fill"></i> Confirm Password
          </label>
          <input type="password" name="confirm_password" class="input-custom"
                 placeholder="Repeat your password" required>
        </div>

        <button type="submit" class="btn-action w-100 justify-content-center mb-3">
          <i class="bi bi-person-plus-fill"></i> Create Account
        </button>

        <!-- Link to login -->
        <p class="login-switch">
          Already have an account? <a href="login.php">Sign in</a>
        </p>

      </form>

    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>