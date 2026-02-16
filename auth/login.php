<?php
session_start();
include("../config/db.php");

$error = "";

if(isset($_POST['login'])){

    $email = $_POST['email'];
    $password = $_POST['password'];

    $query = "SELECT * FROM users WHERE email = '$email'";
    $result = pg_query($conn, $query);

    if(pg_num_rows($result) > 0){

        $row = pg_fetch_assoc($result);

        // 🔐 Password verification
        if(password_verify($password, $row['password'])){

            $_SESSION['user_id'] = $row['id'];
            $_SESSION['user_email'] = $row['email'];

            header("Location: ../dashboard.php");
            exit();

        } else {
            $error = "Invalid Email or Password!";
        }

    } else {
        $error = "Invalid Email or Password!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<div class="container">
    <div class="row justify-content-center mt-5">

        <div class="col-md-4">
            <div class="card shadow p-4">

                <h3 class="text-center mb-4">Login</h3>

                <?php if($error != ""){ ?>
                    <div class="alert alert-danger text-center">
                        <?php echo $error; ?>
                    </div>
                <?php } ?>

                <form method="POST">

                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>

                    <button type="submit" name="login" class="btn btn-primary w-100">
                        Login
                    </button>
                    <a href="register.php" class="d-block text-center mt-3">
                        Don't have account? Register
                    </a>


                </form>

            </div>
        </div>

    </div>
</div>

</body>
</html>
