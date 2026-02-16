<?php
session_start();
include("../config/db.php");

if(!isset($_SESSION['user_id'])){
    header("Location: ../auth/login.php");
    exit();
}

$id = $_GET['id'];

$result = pg_query($conn, "SELECT * FROM customers WHERE id=$id");
$row = pg_fetch_assoc($result);

if(isset($_POST['update'])){
    $name = $_POST['name'];
    $plan = $_POST['plan'];
    $amount = $_POST['amount'];

    $query = "UPDATE customers 
              SET name='$name', plan='$plan', amount=$amount 
              WHERE id=$id";

    pg_query($conn, $query);

    echo "
    <div class='container mt-5'>
     <div class='alert alert-success text-center'>
         ✅ Customer Updated Successfully! Redirecting...
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
?>

<h2>Edit Customer</h2>

<form method="POST">
Name: <input type="text" name="name" value="<?php echo $row['name']; ?>" required><br><br>
Plan: <input type="text" name="plan" value="<?php echo $row['plan']; ?>" required><br><br>
Amount: <input type="number" name="amount" value="<?php echo $row['amount']; ?>" required><br><br>

<button type="submit" name="update">Update</button>
</form>
