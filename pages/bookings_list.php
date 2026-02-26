<?php
include "../db.php";

$sql = "
SELECT b.*, c.full_name AS client_name, s.service_name
FROM bookings b
JOIN clients c ON b.client_id = c.client_id
JOIN services s ON b.service_id = s.service_id
ORDER BY b.booking_id DESC
";
$result = mysqli_query($conn, $sql);
$count  = mysqli_num_rows($result);
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Bookings</title>
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
      <span class="current">Bookings</span>
    </div>

    <!-- Page Header + Create Button -->
    <div class="d-flex align-items-start justify-content-between flex-wrap gap-3 mb-4">
      <div class="dash-header">
        <span class="dash-eyebrow">Management</span>
        <h2 class="dash-title">Bookings</h2>
        <p class="dash-subtitle">View and manage all client booking records.</p>
      </div>
      <a href="bookings_create.php" class="btn-action align-self-center">
        <i class="bi bi-calendar-plus-fill"></i> Create Booking
      </a>
    </div>

    <hr class="dash-divider mb-4">

    <!-- Table -->
    <div class="stats-table-wrap">
      <table class="stats-table">
        <thead>
          <tr>
            <th>ID</th>
            <th>Client</th>
            <th>Service</th>
            <th>Date</th>
            <th>Hours</th>
            <th>Total</th>
            <th>Status</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php if ($count === 0): ?>
            <tr>
              <td colspan="8" class="empty-row">
                <i class="bi bi-calendar-x"></i>
                No bookings found. <a href="bookings_create.php">Create one now.</a>
              </td>
            </tr>
          <?php else: ?>
            <?php while($b = mysqli_fetch_assoc($result)): ?>
              <tr>
                <td class="row-num"><?php echo str_pad($b['booking_id'], 2, '0', STR_PAD_LEFT); ?></td>

                <!-- Client -->
                <td>
                  <div class="d-flex align-items-center gap-3">
                    <div class="client-avatar">
                      <?php echo strtoupper(substr($b['client_name'], 0, 1)); ?>
                    </div>
                    <span class="metric-name"><?php echo htmlspecialchars($b['client_name']); ?></span>
                  </div>
                </td>

                <!-- Service -->
                <td>
                  <div class="d-flex align-items-center gap-2">
                    <div class="service-avatar">
                      <i class="bi bi-briefcase-fill"></i>
                    </div>
                    <span class="text-muted-light"><?php echo htmlspecialchars($b['service_name']); ?></span>
                  </div>
                </td>

                <!-- Date -->
                <td>
                  <span class="text-muted-light">
                    <i class="bi bi-calendar3 me-1" style="color:var(--color-teal);font-size:11px;"></i>
                    <?php echo date('M d, Y', strtotime($b['booking_date'])); ?>
                  </span>
                </td>

                <!-- Hours -->
                <td>
                  <span class="hours-badge">
                    <i class="bi bi-clock-fill"></i>
                    <?php echo $b['hours']; ?>h
                  </span>
                </td>

                <!-- Total -->
                <td>
                  <span class="rate-badge">₱<?php echo number_format($b['total_cost'], 2); ?></span>
                </td>

                <!-- Status -->
                <td>
                  <?php
                    $status = strtoupper($b['status']);
                    if ($status === 'PENDING')  echo '<span class="booking-status status-pending">Pending</span>';
                    elseif ($status === 'PAID')  echo '<span class="booking-status status-paid">Paid</span>';
                    elseif ($status === 'CANCELLED') echo '<span class="booking-status status-cancelled">Cancelled</span>';
                    else echo '<span class="booking-status status-pending">' . htmlspecialchars($b['status']) . '</span>';
                  ?>
                </td>

                <!-- Action -->
                <td>
                  <?php if(strtoupper($b['status']) === 'PENDING'): ?>
                    <a href="payment_process.php?booking_id=<?php echo $b['booking_id']; ?>" class="btn-tbl-pay">
                      <i class="bi bi-cash-coin"></i> Pay
                    </a>
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

    <p class="table-count mt-3">
      <i class="bi bi-calendar-check-fill me-1"></i>
      <?php echo $count; ?> booking<?php echo $count !== 1 ? 's' : ''; ?> total
    </p>

  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>