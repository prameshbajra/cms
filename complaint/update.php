<?php
// Include config file
require_once "config.php";

//Define variables and initialize with empty values
$name = $complaint = $complaint_type = "";
$name_err = $complaint_err = $complaint_type_err = "";
// Processing form data when form is submitted
if(isset($_POST["id"]) && !empty($_POST["id"])){
    // Get hidden input value
    $id = $_POST["id"];

    //Validate name
    $input_name = trim($_POST["name"]);
    if (empty($input_name)) {
        $name_err = "Please enter a name";
        echo "Please enter a name.";
    }
    elseif (!filter_var($input_name, FILTER_VALIDATE_REGEXP, array("options" => array("regexp" => "/^[a-zA-Z\s]+$/")))){
        $name_err = "Please enter a valid name";
        echo "Please enter a valid name";
    }else{
        $name = $input_name;
    }

    //Validate name
    $input_complaint = trim($_POST["complaint"]);
    if (empty($input_complaint)) {
        $complaint_err = "Please enter a complaint";
        echo "Please enter a complaint.";
    }
    elseif (!filter_var($input_complaint, FILTER_VALIDATE_REGEXP, array("options" => array("regexp" => "/^[a-zA-Z\s]+$/")))){
        $complaint_err = "Please enter a valid complaint";
        echo "Please enter a valid complaint";

    }else{
        $complaint = $input_complaint;
    }
    //Validation of complaint type
    $input_complaint_type = trim($_POST["complaint_type"]);
    if(empty($input_complaint_type)){
        $complaint_type_err = "Please enter a complaint type";
        echo "Please enter a complaint type";
    }
    else{
        $complaint_type = $input_complaint_type;
    }

    // Check input errors before inserting in database
    if(empty($name_err) && empty($complaint_err) && empty($complaint_type_err)){
        // Prepare an update statement
        $sql = "UPDATE persons SET name=?, complaint=?, complaint_type=? WHERE id=?";

        if($stmt = mysqli_prepare($conn, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sssi", $param_name, $param_complaint, $param_complaint_type , $param_id);

            // Set parameters
            $param_name = $name;
            $param_complaint = $complaint;
            $param_complaint_type = $complaint_type;
            $param_id = $id;

            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Records updated successfully. Redirect to landing page
                header("location: retrieve_to.php");
                exit();
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }

        // Close statement
        mysqli_stmt_close($stmt);
    }

    // Close connection
    mysqli_close($conn);
} else{
    // Check existence of id parameter before processing further
    if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
        // Get URL parameter
        $id =  trim($_GET["id"]);

        // Prepare a select statement
        $sql = "SELECT * FROM persons WHERE id = ?";
        if($stmt = mysqli_prepare($conn, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "i", $param_id);

            // Set parameters
            $param_id = $id;

            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                $result = mysqli_stmt_get_result($stmt);

                if(mysqli_num_rows($result) == 1){
                    /* Fetch result row as an associative array. Since the result set
                    contains only one row, we don't need to use while loop */
                    $row = mysqli_fetch_array($result);

                    // Retrieve individual field value
                    $name = $row["name"];
                    $complaint = $row["complaint"];
                    $complaint_type = $row["complaint_type"];
                } else{
                    // URL doesn't contain valid id. Redirect to error page
                    header("location: error.php");
                    exit();
                }

            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }

        // Close statement
        mysqli_stmt_close($stmt);

        // Close connection
        mysqli_close($conn);
    }  else{
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
    <input type="text" name="name" value="<?php echo $name; ?>"<br>
    <input type="text" name="complaint" value="<?php echo $complaint; ?>"<br>
    <input type="text" name="complaint_type" value="<?php echo $complaint_type; ?>" <br>
    <input type="hidden" name="id" value="<?php echo $id; ?>"/>
    <input type="submit" value="update">
</form>

</body>
</html>