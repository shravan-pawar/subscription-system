<?php
session_start();
include("../config/db.php");

if(!isset($_SESSION['user_id'])){
    header("Location: ../auth/login.php");
    exit();
}

include("../includes/header.php");

// ----------- SEARCH & FILTER QUERY -----------

$query = "SELECT * FROM customers WHERE 1=1";

if(!empty($_GET['search'])){
    $search = $_GET['search'];
    $query .= " AND LOWER(name) LIKE LOWER('%$search%')";
}

if(!empty($_GET['min_amount'])){
    $min = $_GET['min_amount'];
    $query .= " AND amount >= $min";
}

$query .= " ORDER BY id DESC";

$result = pg_query($conn, $query);
?>

<div class="container mt-4">

<h2 class="mb-4">Customer List</h2>

<!-- 🔍 SEARCH FORM -->
<form method="GET" class="row g-3 mb-4">

    <div class="col-md-4">
        <input type="text" name="search" class="form-control" 
               placeholder="Search by Name"
               value="<?php echo $_GET['search'] ?? ''; ?>">
    </div>

    <div class="col-md-3">
        <input type="number" name="min_amount" class="form-control"
               placeholder="Minimum Amount"
               value="<?php echo $_GET['min_amount'] ?? ''; ?>">
    </div>

    <div class="col-md-2">
        <button type="submit" class="btn btn-primary">Filter</button>
    </div>

    <div class="col-md-2">
        <a href="view_customers.php" class="btn btn-secondary">Reset</a>
    </div>

</form>

<a href="add_customer.php" class="btn btn-success mb-3">
    + Add Customer
</a>

<table class="table table-bordered table-hover shadow">
    <thead class="table-dark">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Plan</th>
            <th>Amount</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>

    <?php while($row = pg_fetch_assoc($result)){ ?>
        <tr>
            <td><?php echo $row['id']; ?></td>
            <td><?php echo $row['name']; ?></td>
            <td><?php echo $row['email']; ?></td>
            <td><?php echo $row['plan']; ?></td>
            <td>₹ <?php echo $row['amount']; ?></td>
            <td>

                <!-- EDIT -->
                <a href="edit_customer.php?id=<?php echo $row['id']; ?>" 
                   class="btn btn-sm btn-warning">Edit</a>

                <!-- DELETE -->
                <a href="delete_customer.php?id=<?php echo $row['id']; ?>" 
                   class="btn btn-sm btn-danger"
                   onclick="return confirm('Are you sure?')">
                   Delete
                </a>

                <!-- 💳 PAYMENTS -->
                <a href="../payments/view_payments.php?customer_id=<?php echo $row['id']; ?>" 
                   class="btn btn-sm btn-info">
                   Payments
                </a>

            </td>
        </tr>
    <?php } ?>

    </tbody>
</table>

</div>

<?php include("../includes/footer.php"); ?>
