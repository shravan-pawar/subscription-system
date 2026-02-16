<?php
session_start();
include("../config/db.php");

if(!isset($_SESSION['user_id'])){
    header("Location: ../auth/login.php");
    exit();
}

$customer_id = $_GET['customer_id'];

if(isset($_POST['add'])){
    $amount = $_POST['amount'];

    $query = "INSERT INTO payments (customer_id, amount, payment_date)
          VALUES ($customer_id, $amount, CURRENT_DATE)";

    pg_query($conn, $query);

    echo "
    <div class='container mt-5'>
     <div class='alert alert-success text-center'>
          💳 Payment Added Successfully! Redirecting...
      </div>
    </div>

    <script>
       setTimeout(function(){
         window.location.href = '../dashboard.php';
     }, 2000);
    </script>
    ";

    exit();

}

include("../includes/header.php");
?>

<h2 class="mb-4">Add Payment</h2>

<div class="card shadow p-4">
<form method="POST">

<div class="mb-3">
    <label class="form-label">Payment Amount</label>
    <input type="number" name="amount" class="form-control" required>
</div>

<button type="submit" name="add" class="btn btn-primary">Add Payment</button>

</form>
</div>

<a href="view_payments.php?customer_id=<?php echo $customer_id; ?>" 
   class="btn btn-secondary mt-3">Back</a>

<?php include("../includes/footer.php"); ?>
