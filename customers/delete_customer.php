<?php
session_start();
include("../config/db.php");

if(!isset($_SESSION['user_id'])){
    header("Location: ../auth/login.php");
    exit();
}

$id = $_GET['id'];

$query = "DELETE FROM customers WHERE id = $id";
pg_query($conn, $query);

echo "
<div class='container mt-5'>
    <div class='alert alert-danger text-center'>
        🗑️ Customer Deleted Successfully! Redirecting...
    </div>
</div>

<script>
    setTimeout(function(){
        window.location.href = '../dashboard.php';
    }, 2000);
</script>
";

exit();

?>
