<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
/* Attempt MySQL server connection. Assuming you are running MySQL
server with default setting (user 'root' with no password) */
$conn = mysqli_connect("localhost", "root", "", "cms");

// Check connection
if ($conn === false) {
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    // Prepare an insert statement
    $sql = "INSERT INTO users (email, password, role) VALUES (?, ?, ?)";

    // Set parameters

    $param_email = trim($_POST['email']);
    $param_password = trim($_POST['password']);
    $param_role = 'customer';

    if ($stmt = mysqli_prepare($conn, $sql)) {
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "sss", $param_email, $param_password, $param_role);

        // Attempt to execute the prepared statement
        if (mysqli_stmt_execute($stmt)) {
            return header("location: success.php");
        } else {
            echo "ERROR: Could not prepare query: $sql. " . mysqli_error($conn);
        }
    } else {
        echo "ERROR: Could not prepare query: $sql. " . mysqli_error($conn);
    }
    // Close statement
    mysqli_stmt_close($stmt);

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

<h2>Register as a new user.</h2>

<form action="register.php" method="post" class="form-floating">
    <label>Email</label>
    <input type="text" name="email">

    <br>

    <label>Password</label>
    <input type="text" name="password">

    <br>


    <button type="submit" class="btn btn-primary">Submit</button>
</form>

</body>
</html>