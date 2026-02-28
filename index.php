<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

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

    <!-- Page Header -->
    <div class="d-flex align-items-start justify-content-between flex-wrap gap-3 mb-2">
      <div class="dash-header">
        <span class="dash-eyebrow">Overview</span>
        <h2 class="dash-title">Dashboard</h2>
        <p class="dash-subtitle">
          Welcome back, <strong><?php echo htmlspecialchars($_SESSION['username']); ?></strong>!
          Here's a summary of your business metrics.
        </p>
      </div>
      <a href="logout.php" class="btn-action-outline align-self-center">
        <i class="bi bi-box-arrow-right"></i> Logout
      </a>
    </div>

    <hr class="dash-divider mb-4">

    <!-- Icon Strip — clickable links -->
    <div class="d-flex flex-wrap gap-3 mb-4 icon-strip">
      <a href="pages/clients_list.php" class="icon-pill">
        <i class="bi bi-people-fill"></i><span>Clients</span>
      </a>
      <a href="pages/services_list.php" class="icon-pill">
        <i class="bi bi-briefcase-fill"></i><span>Services</span>
      </a>
      <a href="pages/bookings_list.php" class="icon-pill">
        <i class="bi bi-calendar-check-fill"></i><span>Bookings</span>
      </a>
      <a href="pages/payments_list.php" class="icon-pill">
        <i class="bi bi-cash-stack"></i><span>Revenue</span>
      </a>
    </div>

    <!-- Stats Table -->
    <div class="stats-table-wrap mb-5">
      <table class="stats-table">
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
            <td>
              <span class="metric-name d-block">Total Clients</span>
              <span class="metric-desc">Registered client accounts</span>
            </td>
            <td><div class="tbl-icon-wrap"><i class="bi bi-people-fill"></i></div></td>
            <td class="row-value"><?php echo $clients; ?></td>
            <td><span class="status-badge status-active">Active</span></td>
          </tr>
          <tr>
            <td class="row-num">02</td>
            <td>
              <span class="metric-name d-block">Total Services</span>
              <span class="metric-desc">Available service offerings</span>
            </td>
            <td><div class="tbl-icon-wrap"><i class="bi bi-briefcase-fill"></i></div></td>
            <td class="row-value"><?php echo $services; ?></td>
            <td><span class="status-badge status-active">Active</span></td>
          </tr>
          <tr>
            <td class="row-num">03</td>
            <td>
              <span class="metric-name d-block">Total Bookings</span>
              <span class="metric-desc">All time booking records</span>
            </td>
            <td><div class="tbl-icon-wrap"><i class="bi bi-calendar-check-fill"></i></div></td>
            <td class="row-value"><?php echo $bookings; ?></td>
            <td><span class="status-badge status-info">Recorded</span></td>
          </tr>
          <tr class="row-highlight">
            <td class="row-num">04</td>
            <td>
              <span class="metric-name d-block">Total Revenue</span>
              <span class="metric-desc">Payments collected to date</span>
            </td>
            <td><div class="tbl-icon-wrap tbl-icon-wrap--gold"><i class="bi bi-cash-stack"></i></div></td>
            <td class="row-value currency">₱<?php echo number_format($revenue, 2); ?></td>
            <td><span class="status-badge status-gold">Collected</span></td>
          </tr>
        </tbody>
      </table>
    </div>

    <!-- Quick Actions -->
    <p class="section-label">Quick Actions</p>
    <div class="d-flex flex-wrap gap-3">
      <a href="pages/clients_add.php" class="btn-action">
        <i class="bi bi-person-plus-fill"></i> Add Client
      </a>
      <a href="pages/services_add.php" class="btn-action">
        <i class="bi bi-plus-circle-fill"></i> Add Service
      </a>
      <a href="pages/bookings_create.php" class="btn-action">
        <i class="bi bi-calendar-plus-fill"></i> Create Booking
      </a>
    </div>

  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>