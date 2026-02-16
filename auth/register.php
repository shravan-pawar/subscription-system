<?php
session_start();
include("../config/db.php");

$message = "";

if(isset($_POST['register'])){

    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $check = pg_query($conn, "SELECT * FROM users WHERE email='$email'");

    if(pg_num_rows($check) > 0){
        $message = "Email already exists!";
    } else {

        $query = "INSERT INTO users (email, password)
                  VALUES ('$email', '$password')";

        pg_query($conn, $query);

        $message = "Registration Successful! You can login now.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Register</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<div class="container mt-5">
<div class="row justify-content-center">
<div class="col-md-4">

<div class="card p-4 shadow">
<h3 class="text-center mb-4">Register</h3>

<?php if($message != ""){ ?>
<div class="alert alert-info text-center">
<?php echo $message; ?>
</div>
<?php } ?>

<form method="POST">

<div class="mb-3">
<label>Email</label>
<input type="email" name="email" class="form-control" required>
</div>

<div class="mb-3">
<label>Password</label>
<input type="password" name="password" class="form-control" required>
</div>

<button type="submit" name="register" class="btn btn-success w-100">
Register
</button>

</form>

<a href="login.php" class="d-block text-center mt-3">
Already have account? Login
</a>

</div>
</div>
</div>
</div>

</body>
</html>
