<?php
include './bootstrap.php';
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
/* Attempt MySQL server connection. Assuming you are running MySQL
server with default setting (user 'root' with no password) */
$conn = mysqli_connect("localhost", "root", "", "cms");
session_start();

// Check connection
if ($conn === false) {
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Prepare an insert statement
    $sql = "SELECT * FROM users WHERE email='$email' AND password='$password'";

    if ($res = mysqli_query($conn, $sql)) {
        if (mysqli_num_rows($res) > 0) {
            $row = mysqli_fetch_array($res);
            $role = $row[3];
            $_SESSION['role'] = $role;
            $_SESSION['user_id'] = $row[0];
            if ($role == 'admin') {
                return header("location: retrieve_to.php");
            }
            return header("location: create.php");
        } else {
            echo "No such user exists. Please try again. \n";
        }
    } else {
        echo "ERROR: Could not prepare query: $sql. " . mysqli_error($conn);
    }

    // Close connection
    mysqli_close($conn);
}
?>


<!doctype html>
<html lang="en">
<head>

    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Register</title>
</head>

<body>

<div class="container">
    <div class="row">
        <div class="col-4 offset-4">
            <br><br><br><br>
            <h2 class="text-center">Login</h2>

            <form action="login.php" method="post">
                <div class="mb-3">
                    <label class="form-label">Email address</label>
                    <input name="email" type="email" class="form-control" id="exampleFormControlInput1"
                           placeholder="name@example.com">
                </div>

                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <input name="password" type="password" class="form-control" id="exampleFormControlInput1"
                           placeholder="password">
                </div>

                <br><br>
                <div class="row">
                    <div class="col-6">
                        <button type="submit" class="w-100 btn btn-warning">Login</button>
                    </div>
                    <div class="col-6">
                        <a class="w-100 btn btn-secondary" href="http://localhost/final_project/complaint/register.php">Register</a>
                    </div>
                </div>
            </form>

            <br>

        </div>
    </div>
</div>
</div>
</body>
</html>
