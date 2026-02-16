<?php
session_start();
include("../config/db.php");

if(!isset($_SESSION['user_id'])){
    header("Location: ../auth/login.php");
    exit();
}

include("../includes/header.php");

// Get total revenue
$result = pg_query($conn, "SELECT SUM(amount) as total FROM customers");
$row = pg_fetch_assoc($result);
$total = $row['total'] ?? 0;

// Get individual customer revenue
$data_result = pg_query($conn, "SELECT name, amount FROM customers");

$names = [];
$amounts = [];

while($data = pg_fetch_assoc($data_result)){
    $names[] = $data['name'];
    $amounts[] = $data['amount'];
}
?>

<h2 class="mb-4">Monthly Revenue Report</h2>

<div class="card shadow p-4 mb-4">
    <h4>Total Revenue: ₹ <?php echo $total; ?></h4>
</div>

<div class="card shadow p-4">
    <canvas id="revenueChart"></canvas>
</div>

<script>
document.addEventListener("DOMContentLoaded", function(){

    const names = <?php echo json_encode($names); ?>;
    const amounts = <?php echo json_encode($amounts); ?>;

    const ctx = document.getElementById('revenueChart');

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: names,
            datasets: [{
                label: 'Customer Revenue',
                data: amounts,
                backgroundColor: 'rgba(54, 162, 235, 0.6)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: { beginAtZero: true }
            }
        }
    });

});
</script>


<?php include("../includes/footer.php"); ?>
