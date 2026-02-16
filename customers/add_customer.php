<?php
session_start();
include("../config/db.php");

if(!isset($_SESSION['user_id'])){
    header("Location: ../auth/login.php");
    exit();
}

if(isset($_POST['add'])){
    $name = $_POST['name'];
    $plan = $_POST['plan'];
    $amount = $_POST['amount'];
    $email = $_POST['email'];

    $query = "INSERT INTO customers (name, email, plan, amount)
          VALUES ('$name', '$email', '$plan', $amount)";

    pg_query($conn, $query);

    echo "
    <div class='container mt-5'>
        <div class='alert alert-success text-center'>
             ✅ Customer Added Successfully! Redirecting to Dashboard...
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

<h2 class="mb-4">Add Customer</h2>

<div class="card shadow p-4">
<form method="POST">

<div class="mb-3">
    <label class="form-label">Name</label>
    <input type="text" name="name" class="form-control" required>
</div>

<div class="mb-3">
    <label class="form-label">Plan</label>
    <input type="text" name="plan" class="form-control" required>
</div>

<div class="mb-3">
    <label class="form-label">Amount</label>
    <input type="number" name="amount" class="form-control" required>
</div>

<div class="mb-3">
    <label class="form-label">Email</label>
    <input type="email" name="email" class="form-control" required>
</div>


<button type="submit" name="add" class="btn btn-success">Add Customer</button>

</form>
</div>

<?php include("../includes/footer.php"); ?>
