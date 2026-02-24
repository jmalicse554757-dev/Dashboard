<?php
include "../db.php";
$id = $_GET['id'];

$get     = mysqli_query($conn, "SELECT * FROM services WHERE service_id = $id");
$service = mysqli_fetch_assoc($get);

if (isset($_POST['update'])) {
  $name   = $_POST['service_name'];
  $desc   = $_POST['description'];
  $rate   = $_POST['hourly_rate'];
  $active = $_POST['is_active'];

  mysqli_query($conn, "UPDATE services
    SET service_name='$name', description='$desc', hourly_rate='$rate', is_active='$active'
    WHERE service_id=$id");

  header("Location: services_list.php");
  exit;
}
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Edit Service</title>
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
      <span class="current">Edit Service</span>
    </div>

    <!-- Page Header -->
    <div class="dash-header mb-4">
      <span class="dash-eyebrow">Services</span>
      <h2 class="dash-title">Edit Service</h2>
      <p class="dash-subtitle">Updating details for <strong><?php echo htmlspecialchars($service['service_name']); ?></strong>.</p>
    </div>

    <hr class="dash-divider mb-4">

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
                     value="<?php echo htmlspecialchars($service['service_name']); ?>"
                     placeholder="e.g. Web Design">
            </div>
          </div>

          <!-- Hourly Rate -->
          <div class="col-md-6">
            <div class="form-group">
              <label class="form-label-custom">
                <i class="bi bi-cash-stack"></i> Hourly Rate (₱) <span class="required">*</span>
              </label>
              <input type="text" name="hourly_rate" class="input-custom"
                     value="<?php echo htmlspecialchars($service['hourly_rate']); ?>"
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
                        style="background-color:#071f2a !important; color:#F3F4F4 !important;"
              ><?php echo htmlspecialchars($service['description']); ?></textarea>
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
                <option value="1" style="background-color:#071f2a; color:#F3F4F4;" <?php if($service['is_active'] == 1) echo "selected"; ?>>Active</option>
                <option value="0" style="background-color:#071f2a; color:#F3F4F4;" <?php if($service['is_active'] == 0) echo "selected"; ?>>Inactive</option>
              </select>
            </div>
          </div>

        </div>

        <hr class="dash-divider my-4">

        <div class="d-flex gap-3">
          <button type="submit" name="update" class="btn-action">
            <i class="bi bi-pencil-fill"></i> Update Service
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