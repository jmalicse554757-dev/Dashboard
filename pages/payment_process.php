<?php
include "../db.php"; // fixed from ../config/db.php

$booking_id = $_GET['booking_id'];

$booking  = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM bookings WHERE booking_id=$booking_id"));

$paidRow    = mysqli_fetch_assoc(mysqli_query($conn, "SELECT IFNULL(SUM(amount_paid),0) AS paid FROM payments WHERE booking_id=$booking_id"));
$total_paid = $paidRow['paid'];
$balance    = $booking['total_cost'] - $total_paid;

$message = "";

if (isset($_POST['pay'])) {
  $amount = $_POST['amount_paid'];
  $method = $_POST['method'];

  if ($amount <= 0) {
    $message = "Invalid amount!";
  } elseif ($amount > $balance) {
    $message = "Amount exceeds balance!";
  } else {
    mysqli_query($conn, "INSERT INTO payments (booking_id, amount_paid, method)
      VALUES ($booking_id, $amount, '$method')");

    $paidRow2    = mysqli_fetch_assoc(mysqli_query($conn, "SELECT IFNULL(SUM(amount_paid),0) AS paid FROM payments WHERE booking_id=$booking_id"));
    $total_paid2 = $paidRow2['paid'];
    $new_balance = $booking['total_cost'] - $total_paid2;

    if ($new_balance <= 0.009) {
      mysqli_query($conn, "UPDATE bookings SET status='PAID' WHERE booking_id=$booking_id");
    }

    header("Location: bookings_list.php");
    exit;
  }
}
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Process Payment</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
  <link href="https://fonts.googleapis.com/css2?family=Syne:wght@600;700;800&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="../style.css">
</head>
<body>
  <?php include "../nav.php"; /* fixed from ../components/nav.php */ ?>

  <div class="container py-5">

    <!-- Breadcrumb -->
    <div class="page-breadcrumb mb-3">
      <a href="../index.php"><i class="bi bi-house-fill"></i> Dashboard</a>
      <span class="sep">/</span>
      <a href="bookings_list.php">Bookings</a>
      <span class="sep">/</span>
      <span class="current">Process Payment</span>
    </div>

    <!-- Page Header -->
    <div class="dash-header mb-4">
      <span class="dash-eyebrow">Payments</span>
      <h2 class="dash-title">Process Payment</h2>
      <p class="dash-subtitle">Booking <strong>#<?php echo $booking_id; ?></strong></p>
    </div>

    <hr class="dash-divider mb-4">

    <!-- Payment Summary Cards -->
    <div class="row g-3 mb-4">
      <div class="col-md-4">
        <div class="payment-summary-card">
          <span class="payment-summary-label"><i class="bi bi-receipt"></i> Total Cost</span>
          <span class="payment-summary-value">₱<?php echo number_format($booking['total_cost'], 2); ?></span>
        </div>
      </div>
      <div class="col-md-4">
        <div class="payment-summary-card">
          <span class="payment-summary-label"><i class="bi bi-check-circle"></i> Total Paid</span>
          <span class="payment-summary-value paid">₱<?php echo number_format($total_paid, 2); ?></span>
        </div>
      </div>
      <div class="col-md-4">
        <div class="payment-summary-card payment-summary-card--balance">
          <span class="payment-summary-label"><i class="bi bi-cash-coin"></i> Balance</span>
          <span class="payment-summary-value balance">₱<?php echo number_format($balance, 2); ?></span>
        </div>
      </div>
    </div>

    <!-- Error Message -->
    <?php if ($message): ?>
      <div class="alert-error mb-4">
        <i class="bi bi-exclamation-triangle-fill me-2"></i><?php echo $message; ?>
      </div>
    <?php endif; ?>

    <!-- Payment Form -->
    <?php if ($balance > 0): ?>
    <p class="section-label">Enter Payment</p>
    <div class="form-card">
      <form method="post" autocomplete="off">
        <div class="row g-4">

          <!-- Amount -->
          <div class="col-md-6">
            <div class="form-group">
              <label class="form-label-custom">
                <i class="bi bi-cash-stack"></i> Amount Paid (₱) <span class="required">*</span>
              </label>
              <input type="number" name="amount_paid" class="input-custom"
                     step="0.01" min="0.01" max="<?php echo $balance; ?>"
                     placeholder="e.g. <?php echo number_format($balance, 2); ?>">
            </div>
          </div>

          <!-- Method -->
          <div class="col-md-6">
            <div class="form-group">
              <label class="form-label-custom">
                <i class="bi bi-credit-card-fill"></i> Payment Method <span class="required">*</span>
              </label>
              <select name="method"
                      class="select-custom"
                      style="background-color:#071f2a !important; color:#F3F4F4 !important;">
                <option value="CASH"  style="background-color:#071f2a; color:#F3F4F4;">💵 Cash</option>
                <option value="GCASH" style="background-color:#071f2a; color:#F3F4F4;">📱 GCash</option>
                <option value="CARD"  style="background-color:#071f2a; color:#F3F4F4;">💳 Card</option>
              </select>
            </div>
          </div>

        </div>

        <hr class="dash-divider my-4">

        <div class="d-flex gap-3">
          <button type="submit" name="pay" class="btn-action">
            <i class="bi bi-cash-coin"></i> Save Payment
          </button>
          <a href="bookings_list.php" class="btn-action-outline">
            <i class="bi bi-x-lg"></i> Cancel
          </a>
        </div>

      </form>
    </div>
    <?php else: ?>
      <div class="alert-success">
        <i class="bi bi-check-circle-fill me-2"></i> This booking is fully paid!
        <a href="bookings_list.php" class="ms-3" style="color:var(--color-teal);">Back to Bookings</a>
      </div>
    <?php endif; ?>

  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>