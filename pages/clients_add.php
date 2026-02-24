<?php
include "../db.php";

$message = "";

if (isset($_POST['save'])) {
  $full_name = $_POST['full_name'];
  $email     = $_POST['email'];
  $phone     = $_POST['phone'];
  $address   = $_POST['address'];

  if ($full_name == "" || $email == "") {
    $message = "Name and Email are required!";
  } else {
    $sql = "INSERT INTO clients (full_name, email, phone, address)
            VALUES ('$full_name', '$email', '$phone', '$address')";
    mysqli_query($conn, $sql);
    header("Location: clients_list.php");
    exit;
  }
}
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Add Client</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
  <link href="https://fonts.googleapis.com/css2?family=Syne:wght@600;700;800&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="../style.css">
</head>
<body>
  <?php include "../nav.php"; ?>

  <div class="container py-5">

    <!-- Breadcrumb -->
    <div class="page-breadcrumb mb-3">
      <a href="../index.php"><i class="bi bi-house-fill"></i> Dashboard</a>
      <span class="sep">/</span>
      <a href="clients_list.php">Clients</a>
      <span class="sep">/</span>
      <span class="current">Add Client</span>
    </div>

    <!-- Page Header -->
    <div class="dash-header mb-4">
      <span class="dash-eyebrow">Clients</span>
      <h2 class="dash-title">Add New Client</h2>
      <p class="dash-subtitle">Fill in the details below to register a new client.</p>
    </div>

    <hr class="dash-divider mb-4">

    <!-- Error Message -->
    <?php if ($message): ?>
      <div class="alert-error mb-4">
        <i class="bi bi-exclamation-triangle-fill me-2"></i><?php echo $message; ?>
      </div>
    <?php endif; ?>

    <!-- Form Card -->
    <div class="form-card">
      <form method="post" autocomplete="off">

        <div class="row g-4">
          <div class="col-md-6">
            <div class="form-group">
              <label class="form-label-custom">
                <i class="bi bi-person-fill"></i> Full Name <span class="required">*</span>
              </label>
              <input type="text" name="full_name" class="input-custom" placeholder="e.g. Juan dela Cruz">
            </div>
          </div>

          <div class="col-md-6">
            <div class="form-group">
              <label class="form-label-custom">
                <i class="bi bi-envelope-fill"></i> Email Address <span class="required">*</span>
              </label>
              <input type="text" name="email" class="input-custom" placeholder="e.g. juan@email.com">
            </div>
          </div>

          <div class="col-md-6">
            <div class="form-group">
              <label class="form-label-custom">
                <i class="bi bi-telephone-fill"></i> Phone Number
              </label>
              <input type="text" name="phone" class="input-custom" placeholder="e.g. 09XX XXX XXXX">
            </div>
          </div>

          <div class="col-md-6">
            <div class="form-group">
              <label class="form-label-custom">
                <i class="bi bi-geo-alt-fill"></i> Address
              </label>
              <input type="text" name="address" class="input-custom" placeholder="e.g. Davao City, Philippines">
            </div>
          </div>
        </div>

        <hr class="dash-divider my-4">

        <div class="d-flex gap-3">
          <button type="submit" name="save" class="btn-action">
            <i class="bi bi-person-check-fill"></i> Save Client
          </button>
          <a href="clients_list.php" class="btn-action-outline">
            <i class="bi bi-x-lg"></i> Cancel
          </a>
        </div>

      </form>
    </div>

  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>