<?php
include "db.php";

$clients  = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS c FROM clients"))['c'];
$services = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS c FROM services"))['c'];
$bookings = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS c FROM bookings"))['c'];

$revRow   = mysqli_fetch_assoc(mysqli_query($conn, "SELECT IFNULL(SUM(amount_paid),0) AS s FROM payments"));
$revenue  = $revRow['s'];
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
  <link href="https://fonts.googleapis.com/css2?family=Syne:wght@600;700;800&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="style.css">
</head>
<body>

  <?php include "nav.php"; ?>

  <div class="container py-5">

    <!-- ── Page Header ── -->
    <div class="dash-header mb-2" style="animation: fadeUp 0.5s ease both;">
      <span class="dash-eyebrow">Overview</span>
      <h2 class="dash-title">Dashboard</h2>
      <p class="dash-subtitle">Here's a summary of your business metrics.</p>
    </div>

    <hr class="dash-divider mb-4">

    <!-- ── Stats Table ── -->
    <div class="stats-table-wrap mb-5" style="animation: fadeUp 0.5s 0.15s ease both;">
      <table class="stats-table w-100">
        <thead>
          <tr>
            <th>#</th>
            <th>Metric</th>
            <th>Icon</th>
            <th>Total</th>
            <th>Status</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td class="row-num">01</td>
            <td class="row-metric">
              <span class="metric-name">Total Clients</span>
              <span class="metric-desc">Registered client accounts</span>
            </td>
            <td>
              <div class="tbl-icon-wrap">
                <i class="bi bi-people-fill"></i>
              </div>
            </td>
            <td class="row-value"><?php echo $clients; ?></td>
            <td><span class="status-badge status-active">Active</span></td>
          </tr>
          <tr>
            <td class="row-num">02</td>
            <td class="row-metric">
              <span class="metric-name">Total Services</span>
              <span class="metric-desc">Available service offerings</span>
            </td>
            <td>
              <div class="tbl-icon-wrap">
                <i class="bi bi-briefcase-fill"></i>
              </div>
            </td>
            <td class="row-value"><?php echo $services; ?></td>
            <td><span class="status-badge status-active">Active</span></td>
          </tr>
          <tr>
            <td class="row-num">03</td>
            <td class="row-metric">
              <span class="metric-name">Total Bookings</span>
              <span class="metric-desc">All time booking records</span>
            </td>
            <td>
              <div class="tbl-icon-wrap">
                <i class="bi bi-calendar-check-fill"></i>
              </div>
            </td>
            <td class="row-value"><?php echo $bookings; ?></td>
            <td><span class="status-badge status-info">Recorded</span></td>
          </tr>
          <tr class="row-highlight">
            <td class="row-num">04</td>
            <td class="row-metric">
              <span class="metric-name">Total Revenue</span>
              <span class="metric-desc">Payments collected to date</span>
            </td>
            <td>
              <div class="tbl-icon-wrap tbl-icon-wrap--gold">
                <i class="bi bi-cash-stack"></i>
              </div>
            </td>
            <td class="row-value currency">₱<?php echo number_format($revenue, 2); ?></td>
            <td><span class="status-badge status-gold">Collected</span></td>
          </tr>
        </tbody>
      </table>
    </div>

    <!-- ── Quick Actions ── -->
    <p class="section-label" style="animation: fadeUp 0.5s 0.35s ease both;">Quick Actions</p>
    <div class="d-flex flex-wrap gap-3" style="animation: fadeUp 0.5s 0.4s ease both;">
      <a href="/assessment_beginner/pages/clients_add.php" class="btn-action">
        <i class="bi bi-person-plus-fill"></i> Add Client
      </a>
      <a href="/assessment_beginner/pages/bookings_create.php" class="btn-action">
        <i class="bi bi-calendar-plus-fill"></i> Create Booking
      </a>
    </div>

  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>