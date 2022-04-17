<?php
// Include config file
require_once "config.php";

//Define variables and initialize with empty values
$user_id = $product_description = $complaint = $status = "";
$user_id_err = $product_description_err = $complaint_err = $status_err = "";
// Processing form data when form is submitted
if (isset($_POST["user_id"]) && !empty($_POST["user_id"])) {
    // Get hidden input value
    $id = $_POST["id"];

    //Validate product description
    $input_product_description = trim($_POST["product_description"]);
    if (empty($input_product_description)) {
        $product_description_err = "Please enter a description";
        echo "Please enter a valid description.";
    } elseif (!filter_var($input_product_description, FILTER_VALIDATE_REGEXP, array("options" => array("regexp" => "/^[a-zA-Z\s]+$/")))) {
        $product_description_err = "Please enter a valid description";
        echo "Please enter a valid description";
    } else {
        $product_description = $input_product_description;
    }

    //Validate complaint
    $input_complaint = trim($_POST["complaint"]);
    if (empty($input_complaint)) {
        $complaint_err = "Please enter a complaint";
        echo "Please enter a complaint.";
    } elseif (!filter_var($input_complaint, FILTER_VALIDATE_REGEXP, array("options" => array("regexp" => "/^[a-zA-Z\s]+$/")))) {
        $complaint_err = "Please enter a valid complaint";
        echo "Please enter a valid complaint";

    } else {
        $complaint = $input_complaint;
    }

    // Check input errors before inserting in database
    if (empty($product_description_err) && empty($complaint_err) && empty($status_err)) {
        // Prepare an update statement
        $sql = "UPDATE complaint SET user_id=?, product_description=?, complaint=?, status=? WHERE id=?";

        if ($stmt = mysqli_prepare($conn, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "isssi", $param_user_id, $param_product_description, $param_complaint, $param_status, $param_id);

            // Set parameters
            $param_user_id = $user_id;
            $param_product_description = $product_description;
            $param_complaint = $complaint;
            $param_status = $status;
            $param_id = $id;

            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                // Records updated successfully. Redirect to landing page
                header("location: retrieve_to.php");
                exit();
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }
        }

        // Close statement
        mysqli_stmt_close($stmt);
    }

    // Close connection
    mysqli_close($conn);
} else {
    // Check existence of id parameter before processing further
    if (isset($_GET["id"]) && !empty(trim($_GET["id"]))) {
        // Get URL parameter
        $id = trim($_GET["id"]);

        // Prepare a select statement
        $sql = "SELECT * FROM complaint WHERE id = ?";
        if ($stmt = mysqli_prepare($conn, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "i", $param_id);

            // Set parameters
            $param_id = $id;

            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                $result = mysqli_stmt_get_result($stmt);

                if (mysqli_num_rows($result) == 1) {
                    /* Fetch result row as an associative array. Since the result set
                    contains only one row, we don't need to use while loop */
                    $row = mysqli_fetch_array($result);

                    // Retrieve individual field value
                    $user_id = $row["user_id"];
                    $product_description = $row["product_description"];
                    $complaint = $row["complaint"];
                    $status = $row["status"];
                } else {
                    // URL doesn't contain valid id. Redirect to error page
                    header("location: error.php");
                    exit();
                }

            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }
        }

        // Close statement
        mysqli_stmt_close($stmt);

        // Close connection
        mysqli_close($conn);
    } else {
        // URL doesn't contain id parameter. Redirect to error page
        header("location: error.php");
        exit();
    }
}
?>
<html>
<head>
    <title>Edit Data</title>
</head>
<body>
<a href="retrieve_to.php">Home</a>
<br><br>
<form method="post" action="">
    <input type="text" user_id="user_id" value="<?php echo $user_id; ?>"<br>
    <input type="text" name="product_description" value="<?php echo $product_description; ?>"<br>
    <input type="text" name="complaint" value="<?php echo $complaint; ?>" <br>
    <input type="hidden" name="id" value="<?php echo $id; ?>"/>
    <input type="submit" value="update">
</form>

</body>
</html>