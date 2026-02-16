<?php
session_start();
include("../config/db.php");

if(!isset($_SESSION['user_id'])){
    header("Location: ../auth/login.php");
    exit();
}

$customer_id = $_GET['customer_id'];

include("../includes/header.php");

// Get customer details
$customer_result = pg_query($conn, "SELECT * FROM customers WHERE id = $customer_id");
$customer = pg_fetch_assoc($customer_result);

// Get payments
$payment_result = pg_query($conn, 
    "SELECT * FROM payments WHERE customer_id = $customer_id ORDER BY payment_date DESC");

// Calculate total paid
$total_result = pg_query($conn,
    "SELECT SUM(amount) as total_paid FROM payments WHERE customer_id = $customer_id");

$total_row = pg_fetch_assoc($total_result);
$total_paid = $total_row['total_paid'] ?? 0;
?>

<h2 class="mb-4">Payment History - <?php echo $customer['name']; ?></h2>

<div class="card shadow p-3 mb-4">
    <h5>Total Paid: ₹ <?php echo $total_paid; ?></h5>
</div>

<a href="add_payment.php?customer_id=<?php echo $customer_id; ?>" 
   class="btn btn-success mb-3">+ Add Payment</a>

<table class="table table-bordered table-hover shadow">
    <thead class="table-primary">
        <tr>
            <th>ID</th>
            <th>Amount</th>
            <th>Payment Date</th>
        </tr>
    </thead>
    <tbody>

    <?php while($row = pg_fetch_assoc($payment_result)){ ?>
        <tr>
            <td><?php echo $row['id']; ?></td>
            <td>₹ <?php echo $row['amount']; ?></td>
            <td><?php echo $row['payment_date']; ?></td>
        </tr>
    <?php } ?>

    </tbody>
</table>

<a href="../customers/view_customers.php" class="btn btn-secondary mt-3">
    Back to Customers
</a>

<?php include("../includes/footer.php"); ?>
