<?php
include './bootstrap.php';

/* Attempt MySQL server connection. Assuming you are running MySQL
server with default setting (user 'root' with no password) */
$conn = mysqli_connect("localhost", "root", "", "cms");
session_start();

// Check connection
if ($conn === false) {
    die("ERROR: Could not connect. " . mysqli_connect_error());
}

if ($_SERVER['REQUEST_METHOD'] == "POST") {

    // Set parameters
    $params_user_id = $_SESSION['user_id'];
    $param_product_description = trim($_POST['product_description']);
    $param_complaint = trim($_POST['complaint']);
    $param_status = 'PENDING';

    // Prepare an insert statement
    $sql = "INSERT INTO complaint (user_id, product_description, complaint, status) VALUES (?, ?, ?, ?)";

    if ($stmt = mysqli_prepare($conn, $sql)) {
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "isss", $params_user_id, $param_product_description, $param_complaint, $param_status);

        // Attempt to execute the prepared statement
        if (mysqli_stmt_execute($stmt)) {
            echo "DONE";
        } else {
            echo "Sorry you cannot create complaint against this product";
        }
    } else {
        echo "Sorry you cannot create complaint against this product";
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
    <title>Form</title>
</head>

<body>



<?php
    if (isset($_SESSION['user_id'])){
        echo '
        <div class="container">
            <div style="float:right;">
                <a class="btn btn-secondary" href="logout.php">Logout</a>
            </div>
            <br><br><br>
            <form action="create.php" method="post" class="form-floating">
                <div class="mb-3">
                    <label class="form-label">Product Description</label>
                    <input name="product_description" type="text" class="form-control" id="exampleFormControlInput1"
                               placeholder="Enter the purchased product">
                </div>
                <div class="mb-3">
                    <label class="form-label">Complaint</label>
                    <input name="complaint" type="text" class="form-control" id="exampleFormControlInput1"
                       placeholder="File a complaint">
                </div>

                <br>
                <button type="submit" class="btn btn-warning">Submit</button>
            </form>
        </div>';
    } else {
        echo "<h3>You are not supposed to be here</h3>";
    }
?>
</body>
</html>