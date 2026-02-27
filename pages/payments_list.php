<?php
include "../db.php";

$sql = "
SELECT p.*, b.booking_date, c.full_name
FROM payments p
JOIN bookings b ON p.booking_id = b.booking_id
JOIN clients c ON b.client_id = c.client_id
ORDER BY p.payment_id DESC
";
$result = mysqli_query($conn, $sql);
$count  = mysqli_num_rows($result);
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Payments</title>
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
      <span class="current">Payments</span>
    </div>

    <!-- Page Header -->
    <div class="dash-header mb-4">
      <span class="dash-eyebrow">Finance</span>
      <h2 class="dash-title">Payments</h2>
      <p class="dash-subtitle">View all collected payments across all bookings.</p>
    </div>

    <hr class="dash-divider mb-4">

    <!-- Table -->
    <div class="stats-table-wrap">
      <table class="stats-table">
        <thead>
          <tr>
            <th>ID</th>
            <th>Client</th>
            <th>Booking</th>
            <th>Amount</th>
            <th>Method</th>
            <th>Date</th>
          </tr>
        </thead>
        <tbody>
          <?php if ($count === 0): ?>
            <tr>
              <td colspan="6" class="empty-row">
                <i class="bi bi-cash-stack"></i>
                No payments recorded yet.
              </td>
            </tr>
          <?php else: ?>
            <?php while($p = mysqli_fetch_assoc($result)): ?>
              <tr>
                <td class="row-num"><?php echo str_pad($p['payment_id'], 2, '0', STR_PAD_LEFT); ?></td>

                <!-- Client -->
                <td>
                  <div class="d-flex align-items-center gap-3">
                    <div class="client-avatar">
                      <?php echo strtoupper(substr($p['full_name'], 0, 1)); ?>
                    </div>
                    <span class="metric-name"><?php echo htmlspecialchars($p['full_name']); ?></span>
                  </div>
                </td>

                <!-- Booking -->
                <td>
                  <span class="hours-badge">
                    <i class="bi bi-calendar3"></i>
                    #<?php echo $p['booking_id']; ?>
                  </span>
                </td>

                <!-- Amount -->
                <td>
                  <span class="rate-badge">₱<?php echo number_format($p['amount_paid'], 2); ?></span>
                </td>

                <!-- Method -->
                <td>
                  <?php
                    $method = strtoupper($p['method']);
                    if ($method === 'CASH')       echo '<span class="method-badge method-cash"><i class="bi bi-cash"></i> Cash</span>';
                    elseif ($method === 'GCASH')  echo '<span class="method-badge method-gcash"><i class="bi bi-phone"></i> GCash</span>';
                    elseif ($method === 'CARD')   echo '<span class="method-badge method-card"><i class="bi bi-credit-card"></i> Card</span>';
                    else echo '<span class="text-muted-light">' . htmlspecialchars($p['method']) . '</span>';
                  ?>
                </td>

                <!-- Date -->
                <td>
                  <span class="text-muted-light">
                    <i class="bi bi-calendar3 me-1" style="color:var(--color-teal);font-size:11px;"></i>
                    <?php echo date('M d, Y', strtotime($p['payment_date'])); ?>
                  </span>
                </td>

              </tr>
            <?php endwhile; ?>
          <?php endif; ?>
        </tbody>
      </table>
    </div>

    <p class="table-count mt-3">
      <i class="bi bi-cash-stack me-1"></i>
      <?php echo $count; ?> payment<?php echo $count !== 1 ? 's' : ''; ?> total
    </p>

  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>