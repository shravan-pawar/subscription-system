<?php
session_start();
include("config/db.php");

if(!isset($_SESSION['user_id'])){
    header("Location: auth/login.php");
    exit();
}

include("includes/header.php");

// 🔢 Total Customers
$total_customers_query = pg_query($conn, "SELECT COUNT(*) as total FROM customers");
$total_customers = pg_fetch_assoc($total_customers_query)['total'];

// 💰 Total Revenue
$total_revenue_query = pg_query($conn, "SELECT SUM(amount) as revenue FROM payments");
$total_revenue = pg_fetch_assoc($total_revenue_query)['revenue'] ?? 0;

// 📊 Monthly Revenue Data
$monthly_query = pg_query($conn, "
    SELECT 
        TO_CHAR(payment_date, 'Mon') as month,
        SUM(amount) as total
    FROM payments
    GROUP BY month
    ORDER BY MIN(payment_date)
");

$months = [];
$revenues = [];

while($row = pg_fetch_assoc($monthly_query)){
    $months[] = $row['month'];
    $revenues[] = $row['total'];
}
?>

<div class="container mt-4">

<h2 class="mb-4">Dashboard</h2>

<!-- 🔥 QUICK ACTION CARDS -->
<div class="row mb-4">

    <div class="col-md-3">
        <a href="customers/add_customer.php" class="text-decoration-none">
            <div class="card text-center shadow p-3">
                <h5>➕ Add Customer</h5>
            </div>
        </a>
    </div>

    <div class="col-md-3">
        <a href="customers/view_customers.php" class="text-decoration-none">
            <div class="card text-center shadow p-3">
                <h5>👥 View Customers</h5>
            </div>
        </a>
    </div>

    <div class="col-md-3">
        <a href="reports/monthly_report.php" class="text-decoration-none">
            <div class="card text-center shadow p-3">
                <h5>📊 Monthly Report</h5>
            </div>
        </a>
    </div>

    <div class="col-md-3">
        <a href="auth/logout.php" class="text-decoration-none">
            <div class="card text-center shadow p-3 bg-danger text-white">
                <h5>🚪 Logout</h5>
            </div>
        </a>
    </div>

</div>

<!-- 📊 STAT CARDS -->
<div class="row mb-4">

    <div class="col-md-6">
        <div class="card shadow p-4 text-center">
            <h5>Total Customers</h5>
            <h2><?php echo $total_customers; ?></h2>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card shadow p-4 text-center">
            <h5>Total Revenue</h5>
            <h2>₹ <?php echo $total_revenue; ?></h2>
        </div>
    </div>

</div>

<!-- 📈 CHART -->
<div class="card shadow p-4">
    <h5 class="mb-3">Monthly Revenue</h5>
    <canvas id="revenueChart"></canvas>
</div>

</div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
const ctx = document.getElementById('revenueChart').getContext('2d');

new Chart(ctx, {
    type: 'bar',
    data: {
        labels: <?php echo json_encode($months); ?>,
        datasets: [{
            label: 'Revenue',
            data: <?php echo json_encode($revenues); ?>,
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});
</script>

<?php include("includes/footer.php"); ?>
