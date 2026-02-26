<?php
include "../db.php";

$clients  = mysqli_query($conn, "SELECT * FROM clients ORDER BY full_name ASC");
$services = mysqli_query($conn, "SELECT * FROM services WHERE is_active=1 ORDER BY service_name ASC");

if (isset($_POST['create'])) {
  $client_id    = $_POST['client_id'];
  $service_id   = $_POST['service_id'];
  $booking_date = $_POST['booking_date'];
  $hours        = $_POST['hours'];

  $s    = mysqli_fetch_assoc(mysqli_query($conn, "SELECT hourly_rate FROM services WHERE service_id=$service_id"));
  $rate = $s['hourly_rate'];
  $total = $rate * $hours;

  mysqli_query($conn, "INSERT INTO bookings (client_id, service_id, booking_date, hours, hourly_rate_snapshot, total_cost, status)
    VALUES ($client_id, $service_id, '$booking_date', $hours, $rate, $total, 'PENDING')");

  header("Location: bookings_list.php");
  exit;
}
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Create Booking</title>
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
      <a href="bookings_list.php">Bookings</a>
      <span class="sep">/</span>
      <span class="current">Create Booking</span>
    </div>

    <!-- Page Header -->
    <div class="dash-header mb-4">
      <span class="dash-eyebrow">Bookings</span>
      <h2 class="dash-title">Create Booking</h2>
      <p class="dash-subtitle">Fill in the details below to schedule a new booking.</p>
    </div>

    <hr class="dash-divider mb-4">

    <!-- Form Card -->
    <div class="form-card">
      <form method="post" autocomplete="off">
        <div class="row g-4">

          <!-- Client -->
          <div class="col-md-6">
            <div class="form-group">
              <label class="form-label-custom">
                <i class="bi bi-person-fill"></i> Client <span class="required">*</span>
              </label>
              <select name="client_id"
                      class="select-custom"
                      style="background-color:#071f2a !important; color:#F3F4F4 !important;">
                <?php while($c = mysqli_fetch_assoc($clients)): ?>
                  <option value="<?php echo $c['client_id']; ?>"
                          style="background-color:#071f2a; color:#F3F4F4;">
                    <?php echo htmlspecialchars($c['full_name']); ?>
                  </option>
                <?php endwhile; ?>
              </select>
            </div>
          </div>

          <!-- Service -->
          <div class="col-md-6">
            <div class="form-group">
              <label class="form-label-custom">
                <i class="bi bi-briefcase-fill"></i> Service <span class="required">*</span>
              </label>
              <select name="service_id"
                      class="select-custom"
                      style="background-color:#071f2a !important; color:#F3F4F4 !important;">
                <?php while($s = mysqli_fetch_assoc($services)): ?>
                  <option value="<?php echo $s['service_id']; ?>"
                          style="background-color:#071f2a; color:#F3F4F4;">
                    <?php echo htmlspecialchars($s['service_name']); ?>
                    (₱<?php echo number_format($s['hourly_rate'], 2); ?>/hr)
                  </option>
                <?php endwhile; ?>
              </select>
            </div>
          </div>

          <!-- Date -->
          <div class="col-md-6">
            <div class="form-group">
              <label class="form-label-custom">
                <i class="bi bi-calendar3"></i> Booking Date <span class="required">*</span>
              </label>
              <input type="date" name="booking_date" class="input-custom">
            </div>
          </div>

          <!-- Hours -->
          <div class="col-md-6">
            <div class="form-group">
              <label class="form-label-custom">
                <i class="bi bi-clock-fill"></i> Hours <span class="required">*</span>
              </label>
              <input type="number" name="hours" class="input-custom" min="1" value="1" placeholder="e.g. 3">
            </div>
          </div>

        </div>

        <hr class="dash-divider my-4">

        <div class="d-flex gap-3">
          <button type="submit" name="create" class="btn-action">
            <i class="bi bi-calendar-check-fill"></i> Create Booking
          </button>
          <a href="bookings_list.php" class="btn-action-outline">
            <i class="bi bi-x-lg"></i> Cancel
          </a>
        </div>

      </form>
    </div>

  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>