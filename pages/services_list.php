<?php
include "../db.php";

// Soft delete (deactivate)
if (isset($_GET['delete_id'])) {
  $delete_id = $_GET['delete_id'];
  mysqli_query($conn, "UPDATE services SET is_active=0 WHERE service_id=$delete_id");
  header("Location: services_list.php");
  exit;
}

$result = mysqli_query($conn, "SELECT * FROM services ORDER BY service_id DESC");
$count  = mysqli_num_rows($result);
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Services</title>
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
      <span class="current">Services</span>
    </div>

    <!-- Page Header + Add Button -->
    <div class="d-flex align-items-start justify-content-between flex-wrap gap-3 mb-4">
      <div class="dash-header">
        <span class="dash-eyebrow">Management</span>
        <h2 class="dash-title">Services</h2>
        <p class="dash-subtitle">View, manage and edit all available service offerings.</p>
      </div>
      <a href="services_add.php" class="btn-action align-self-center">
        <i class="bi bi-plus-circle-fill"></i> Add Service
      </a>
    </div>

    <hr class="dash-divider mb-4">

    <!-- Table -->
    <div class="stats-table-wrap">
      <table class="stats-table">
        <thead>
          <tr>
            <th>ID</th>
            <th>Service</th>
            <th>Hourly Rate</th>
            <th>Status</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php if ($count === 0): ?>
            <tr>
              <td colspan="5" class="empty-row">
                <i class="bi bi-briefcase"></i>
                No services found. <a href="services_add.php">Add one now.</a>
              </td>
            </tr>
          <?php else: ?>
            <?php while($row = mysqli_fetch_assoc($result)): ?>
              <tr>
                <td class="row-num"><?php echo str_pad($row['service_id'], 2, '0', STR_PAD_LEFT); ?></td>
                <td>
                  <div class="d-flex align-items-center gap-3">
                    <div class="service-avatar">
                      <i class="bi bi-briefcase-fill"></i>
                    </div>
                    <div>
                      <span class="metric-name d-block"><?php echo htmlspecialchars($row['service_name']); ?></span>
                      <?php if (!empty($row['description'])): ?>
                        <span class="metric-desc"><?php echo htmlspecialchars(substr($row['description'], 0, 55)) . (strlen($row['description']) > 55 ? '…' : ''); ?></span>
                      <?php endif; ?>
                    </div>
                  </div>
                </td>
                <td>
                  <span class="rate-badge">₱<?php echo number_format($row['hourly_rate'], 2); ?>/hr</span>
                </td>
                <td>
                  <?php if ($row['is_active'] == 1): ?>
                    <span class="badge-yes">Active</span>
                  <?php else: ?>
                    <span class="badge-no">Inactive</span>
                  <?php endif; ?>
                </td>
                <td>
                  <div class="d-flex gap-2">
                    <a href="services_edit.php?id=<?php echo $row['service_id']; ?>" class="btn-tbl-edit">
                      <i class="bi bi-pencil-fill"></i> Edit
                    </a>
                    <?php if ($row['is_active'] == 1): ?>
                      <a href="services_list.php?delete_id=<?php echo $row['service_id']; ?>"
                         class="btn-tbl-deactivate"
                         onclick="return confirm('Deactivate this service?')">
                        <i class="bi bi-slash-circle-fill"></i> Deactivate
                      </a>
                    <?php endif; ?>
                  </div>
                </td>
              </tr>
            <?php endwhile; ?>
          <?php endif; ?>
        </tbody>
      </table>
    </div>

    <p class="table-count mt-3">
      <i class="bi bi-briefcase-fill me-1"></i>
      <?php echo $count; ?> service<?php echo $count !== 1 ? 's' : ''; ?> total
    </p>

  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>