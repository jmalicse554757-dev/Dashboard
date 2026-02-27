<?php
include "../db.php";

$message     = "";
$messageType = "";

// ASSIGN TOOL
if (isset($_POST['assign'])) {
  $booking_id = $_POST['booking_id'];
  $tool_id    = $_POST['tool_id'];
  $qty        = $_POST['qty_used'];

  $toolRow = mysqli_fetch_assoc(mysqli_query($conn, "SELECT quantity_available FROM tools WHERE tool_id=$tool_id"));

  if ($qty > $toolRow['quantity_available']) {
    $message     = "Not enough available tools!";
    $messageType = "error";
  } else {
    mysqli_query($conn, "INSERT INTO booking_tools (booking_id, tool_id, qty_used)
      VALUES ($booking_id, $tool_id, $qty)");
    mysqli_query($conn, "UPDATE tools SET quantity_available = quantity_available - $qty WHERE tool_id=$tool_id");
    $message     = "Tool assigned successfully!";
    $messageType = "success";
  }
}

$tools    = mysqli_query($conn, "SELECT * FROM tools ORDER BY tool_name ASC");
$bookings = mysqli_query($conn, "SELECT booking_id FROM bookings ORDER BY booking_id DESC");
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Tools / Inventory</title>
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
      <span class="current">Tools</span>
    </div>

    <!-- Page Header -->
    <div class="dash-header mb-4">
      <span class="dash-eyebrow">Inventory</span>
      <h2 class="dash-title">Tools / Inventory</h2>
      <p class="dash-subtitle">Manage available tools and assign them to bookings.</p>
    </div>

    <hr class="dash-divider mb-4">

    <!-- Alert Message -->
    <?php if ($message): ?>
      <?php if ($messageType === 'success'): ?>
        <div class="alert-success mb-4">
          <i class="bi bi-check-circle-fill me-2"></i><?php echo $message; ?>
        </div>
      <?php else: ?>
        <div class="alert-error mb-4">
          <i class="bi bi-exclamation-triangle-fill me-2"></i><?php echo $message; ?>
        </div>
      <?php endif; ?>
    <?php endif; ?>

    <!-- ── Tools Inventory Table ── -->
    <p class="section-label">Available Tools</p>
    <div class="stats-table-wrap mb-5">
      <table class="stats-table">
        <thead>
          <tr>
            <th>ID</th>
            <th>Tool Name</th>
            <th>Total Stock</th>
            <th>Available</th>
            <th>In Use</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $toolsCount = mysqli_num_rows($tools);
          if ($toolsCount === 0): ?>
            <tr>
              <td colspan="5" class="empty-row">
                <i class="bi bi-tools"></i>
                No tools found in inventory.
              </td>
            </tr>
          <?php else: ?>
            <?php while($t = mysqli_fetch_assoc($tools)):
              $in_use = $t['quantity_total'] - $t['quantity_available'];
            ?>
              <tr>
                <td class="row-num"><?php echo str_pad($t['tool_id'], 2, '0', STR_PAD_LEFT); ?></td>
                <td>
                  <div class="d-flex align-items-center gap-3">
                    <div class="tool-avatar">
                      <i class="bi bi-wrench-adjustable"></i>
                    </div>
                    <span class="metric-name"><?php echo htmlspecialchars($t['tool_name']); ?></span>
                  </div>
                </td>
                <td>
                  <span class="text-muted-light"><?php echo $t['quantity_total']; ?> pcs</span>
                </td>
                <td>
                  <?php if ($t['quantity_available'] > 0): ?>
                    <span class="badge-yes"><?php echo $t['quantity_available']; ?> available</span>
                  <?php else: ?>
                    <span class="badge-no">Out of stock</span>
                  <?php endif; ?>
                </td>
                <td>
                  <?php if ($in_use > 0): ?>
                    <span class="hours-badge"><i class="bi bi-hammer"></i> <?php echo $in_use; ?> in use</span>
                  <?php else: ?>
                    <span class="no-data">—</span>
                  <?php endif; ?>
                </td>
              </tr>
            <?php endwhile; ?>
          <?php endif; ?>
        </tbody>
      </table>
    </div>

    <!-- ── Assign Tool Form ── -->
    <p class="section-label">Assign Tool to Booking</p>
    <div class="form-card">
      <form method="post" autocomplete="off">
        <div class="row g-4">

          <!-- Booking ID -->
          <div class="col-md-4">
            <div class="form-group">
              <label class="form-label-custom">
                <i class="bi bi-calendar-check-fill"></i> Booking ID <span class="required">*</span>
              </label>
              <select name="booking_id"
                      class="select-custom"
                      style="background-color:#071f2a !important; color:#F3F4F4 !important;">
                <?php while($b = mysqli_fetch_assoc($bookings)): ?>
                  <option value="<?php echo $b['booking_id']; ?>"
                          style="background-color:#071f2a; color:#F3F4F4;">
                    Booking #<?php echo $b['booking_id']; ?>
                  </option>
                <?php endwhile; ?>
              </select>
            </div>
          </div>

          <!-- Tool -->
          <div class="col-md-4">
            <div class="form-group">
              <label class="form-label-custom">
                <i class="bi bi-wrench-adjustable"></i> Tool <span class="required">*</span>
              </label>
              <?php $tools2 = mysqli_query($conn, "SELECT * FROM tools ORDER BY tool_name ASC"); ?>
              <select name="tool_id"
                      class="select-custom"
                      style="background-color:#071f2a !important; color:#F3F4F4 !important;">
                <?php while($t2 = mysqli_fetch_assoc($tools2)): ?>
                  <option value="<?php echo $t2['tool_id']; ?>"
                          style="background-color:#071f2a; color:#F3F4F4;">
                    <?php echo htmlspecialchars($t2['tool_name']); ?>
                    (Avail: <?php echo $t2['quantity_available']; ?>)
                  </option>
                <?php endwhile; ?>
              </select>
            </div>
          </div>

          <!-- Qty Used -->
          <div class="col-md-4">
            <div class="form-group">
              <label class="form-label-custom">
                <i class="bi bi-hash"></i> Qty Used <span class="required">*</span>
              </label>
              <input type="number" name="qty_used" class="input-custom" min="1" value="1">
            </div>
          </div>

        </div>

        <hr class="dash-divider my-4">

        <div class="d-flex gap-3">
          <button type="submit" name="assign" class="btn-action">
            <i class="bi bi-hammer"></i> Assign Tool
          </button>
        </div>

      </form>
    </div>

  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>