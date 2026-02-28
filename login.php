<?php
session_start();

// Already logged in → go to dashboard
if (isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}

include "db.php";

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    if ($username == "" || $password == "") {
        $error = "Please enter both username and password.";
    } else {
        // Fetch user from database
        $result = mysqli_query($conn, "SELECT * FROM users WHERE username='$username'");

        if ($row = mysqli_fetch_assoc($result)) {
            // Verify hashed password
            if (password_verify($password, $row['password'])) {
                $_SESSION['username'] = $row['username'];
                header("Location: index.php");
                exit();
            } else {
                $error = "Invalid username or password!";
            }
        } else {
            $error = "Invalid username or password!";
        }
    }
}
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Login — Service Dashboard</title>
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
      </div>

      <h2 class="login-title">Welcome back</h2>
      <p class="login-sub">Sign in to your dashboard</p>

      <!-- Error -->
      <?php if ($error): ?>
        <div class="alert-error mb-4">
          <i class="bi bi-exclamation-triangle-fill me-2"></i><?php echo $error; ?>
        </div>
      <?php endif; ?>

      <!-- Form -->
      <form method="POST" autocomplete="off">

        <div class="form-group mb-3">
          <label class="form-label-custom">
            <i class="bi bi-person-fill"></i> Username
          </label>
          <input type="text" name="username" class="input-custom"
                 placeholder="Enter username" required
                 value="<?php echo isset($_POST['username']) ? htmlspecialchars($_POST['username']) : ''; ?>">
        </div>

        <div class="form-group mb-4">
          <label class="form-label-custom">
            <i class="bi bi-lock-fill"></i> Password
          </label>
          <input type="password" name="password" class="input-custom"
                 placeholder="Enter password" required>
        </div>

        <button type="submit" class="btn-action w-100 justify-content-center mb-3">
          <i class="bi bi-box-arrow-in-right"></i> Sign In
        </button>

        <!-- Link to register -->
        <p class="login-switch">
          Don't have an account? <a href="register.php">Create one</a>
        </p>

      </form>

    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>