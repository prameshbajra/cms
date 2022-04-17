<?php
    /* Attempt MySQL server connection. Assuming you are running MySQL
    server with default setting (user 'root' with no password) */
    $conn = mysqli_connect("localhost", "root", "", "cms");

    // Check connection
    if ($conn === false) {
        die("ERROR: Could not connect. " . mysqli_connect_error());
    }
    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        // Prepare an insert statement
        $sql = "INSERT INTO complaint (name, complaint, complaint_type) VALUES (?, ?, ?)";

        // Set parameters

        $param_name = trim($_POST['name']);
        $param_complaint = trim($_POST['complaint']);
        $param_complaint_type = trim($_POST['complaint_type']);

        echo $param_name;
        echo $param_complaint;
        echo $param_complaint_type;

        if ($stmt = mysqli_prepare($conn, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sss", $param_name, $param_complaint, $param_complaint_type);

            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                echo "3";
                // header("location: retrieve_to.php");
            } else {
                echo "ERROR: Could not execute query: $sql. " . mysqli_error($conn);
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
    <title>Form</title>
</head>

<body>


<form action="create.php" method="post" class="form-floating">
    <label>Name</label>
    <input type="text" name="name">

    <br>

    <label>Complaint</label>
    <input type="text" name="complaint">

    <br>

    <label>Complaint Type</label>
    <input type="text" name="complaint_type">


<br>

    <button type="submit" class="btn btn-primary">Submit</button>
</form>

</body>
</html>