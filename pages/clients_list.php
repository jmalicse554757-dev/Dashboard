<?php
include "../db.php";
$result = mysqli_query($conn, "SELECT * FROM clients ORDER BY client_id DESC");
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Clients</title>
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
      <span class="current">Clients</span>
    </div>

    <!-- Page Header + Add Button -->
    <div class="d-flex align-items-start justify-content-between flex-wrap gap-3 mb-4">
      <div class="dash-header">
        <span class="dash-eyebrow">Management</span>
        <h2 class="dash-title">Clients</h2>
        <p class="dash-subtitle">View, manage and edit all registered clients.</p>
      </div>
      <a href="clients_add.php" class="btn-action align-self-center">
        <i class="bi bi-person-plus-fill"></i> Add Client
      </a>
    </div>

    <hr class="dash-divider mb-4">

    <!-- Table -->
    <div class="stats-table-wrap">
      <table class="stats-table w-100">
        <thead>
          <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $count = mysqli_num_rows($result);
          if ($count === 0): ?>
            <tr>
              <td colspan="5" class="empty-row">
                <i class="bi bi-people"></i>
                <span>No clients found. <a href="clients_add.php">Add one now.</a></span>
              </td>
            </tr>
          <?php else: ?>
          <?php while($row = mysqli_fetch_assoc($result)): ?>
            <tr>
              <td class="row-num"><?php echo str_pad($row['client_id'], 2, '0', STR_PAD_LEFT); ?></td>
              <td>
                <div class="d-flex align-items-center gap-3">
                  <div class="client-avatar">
                    <?php echo strtoupper(substr($row['full_name'], 0, 1)); ?>
                  </div>
                  <span class="metric-name"><?php echo htmlspecialchars($row['full_name']); ?></span>
                </div>
              </td>
              <td>
                <span class="text-muted-light">
                  <i class="bi bi-envelope me-1" style="color: var(--color-teal); font-size:12px;"></i>
                  <?php echo htmlspecialchars($row['email']); ?>
                </span>
              </td>
              <td>
                <span class="text-muted-light">
                  <?php echo $row['phone'] ? htmlspecialchars($row['phone']) : '<span class="no-data">—</span>'; ?>
                </span>
              </td>
              <td>
                <div class="d-flex gap-2">
                  <a href="clients_edit.php?id=<?php echo $row['client_id']; ?>" class="btn-tbl-edit">
                    <i class="bi bi-pencil-fill"></i> Edit
                  </a>
                </div>
              </td>
            </tr>
          <?php endwhile; ?>
          <?php endif; ?>
        </tbody>
      </table>
    </div>

    <!-- Row count -->
    <p class="table-count mt-3">
      <i class="bi bi-people-fill me-1"></i>
      <?php echo $count; ?> client<?php echo $count !== 1 ? 's' : ''; ?> total
    </p>

  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>