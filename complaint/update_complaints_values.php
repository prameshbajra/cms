<?php
    $link = mysqli_connect("localhost", "root", "", "cms");

    $product_description = trim($_POST['product_description']);
    $complaint = trim($_POST['complaint']);
    $status = trim($_POST['status']);
    $user_id = trim($_POST['user_id']);
    $id = trim($_POST['id']);

    // Attempt update query execution
    $sql = "UPDATE complaint SET product_description='$product_description', complaint = '$complaint', status = '$status' 
            WHERE id='$id'";

    if(mysqli_query($link, $sql)){
        echo "Complaint Updated Successfully";
        header("location: retrieve_to.php");
    } else {
        echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
    }

    // Close connection
    mysqli_close($link);

?>