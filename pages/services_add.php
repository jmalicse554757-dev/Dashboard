<?php
include "../db.php";

$message = "";

if (isset($_POST['save'])) {
  $service_name = $_POST['service_name'];
  $description  = $_POST['description'];
  $hourly_rate  = $_POST['hourly_rate'];
  $is_active    = $_POST['is_active'];

  if ($service_name == "" || $hourly_rate == "") {
    $message = "Service name and hourly rate are required!";
  } elseif (!is_numeric($hourly_rate) || $hourly_rate <= 0) {
    $message = "Hourly rate must be a number greater than 0.";
  } else {
    $sql = "INSERT INTO services (service_name, description, hourly_rate, is_active)
            VALUES ('$service_name', '$description', '$hourly_rate', '$is_active')";
    mysqli_query($conn, $sql);
    header("Location: services_list.php");
    exit;
  }
}
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Add Service</title>
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
      <a href="services_list.php">Services</a>
      <span class="sep">/</span>
      <span class="current">Add Service</span>
    </div>

    <!-- Page Header -->
    <div class="dash-header mb-4">
      <span class="dash-eyebrow">Services</span>
      <h2 class="dash-title">Add New Service</h2>
      <p class="dash-subtitle">Fill in the details below to register a new service.</p>
    </div>

    <hr class="dash-divider mb-4">

    <!-- Error -->
    <?php if ($message): ?>
      <div class="alert-error mb-4">
        <i class="bi bi-exclamation-triangle-fill me-2"></i><?php echo $message; ?>
      </div>
    <?php endif; ?>

    <!-- Form Card -->
    <div class="form-card">
      <form method="post" autocomplete="off">
        <div class="row g-4">

          <!-- Service Name -->
          <div class="col-md-6">
            <div class="form-group">
              <label class="form-label-custom">
                <i class="bi bi-briefcase-fill"></i> Service Name <span class="required">*</span>
              </label>
              <input type="text" name="service_name" class="input-custom"
                     placeholder="e.g. Carpentry Works">
            </div>
          </div>

          <!-- Hourly Rate -->
          <div class="col-md-6">
            <div class="form-group">
              <label class="form-label-custom">
                <i class="bi bi-cash-stack"></i> Hourly Rate (₱) <span class="required">*</span>
              </label>
              <input type="text" name="hourly_rate" class="input-custom"
                     placeholder="e.g. 500.00">
            </div>
          </div>

          <!-- Description -->
          <div class="col-12">
            <div class="form-group">
              <label class="form-label-custom">
                <i class="bi bi-card-text"></i> Description
              </label>
              <textarea name="description"
                        class="textarea-custom"
                        placeholder="Brief description of the service..."
                        style="background-color:#071f2a !important; color:#F3F4F4 !important;"></textarea>
            </div>
          </div>

          <!-- Status -->
          <div class="col-md-4">
            <div class="form-group">
              <label class="form-label-custom">
                <i class="bi bi-toggle-on"></i> Status
              </label>
              <select name="is_active"
                      class="select-custom"
                      style="background-color:#071f2a !important; color:#F3F4F4 !important;">
                <option value="1" style="background-color:#071f2a; color:#F3F4F4;">Active</option>
                <option value="0" style="background-color:#071f2a; color:#F3F4F4;">Inactive</option>
              </select>
            </div>
          </div>

        </div>

        <hr class="dash-divider my-4">

        <div class="d-flex gap-3">
          <button type="submit" name="save" class="btn-action">
            <i class="bi bi-briefcase-fill"></i> Save Service
          </button>
          <a href="services_list.php" class="btn-action-outline">
            <i class="bi bi-x-lg"></i> Cancel
          </a>
        </div>

      </form>
    </div>

  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>