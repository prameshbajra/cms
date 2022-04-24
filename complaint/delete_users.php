<?php
include './bootstrap.php';

require_once "config.php";

session_start();

$sql_user = "DELETE FROM users WHERE id = ?";
$sql_complaints = "DELETE FROM complaint WHERE user_id = ?";

if (isset($_SESSION['role']) && $_SESSION['role'] == 'admin') {

    $stmt_complaints = mysqli_prepare($conn, $sql_complaints);
    $stmt_users = mysqli_prepare($conn, $sql_user);

    $param_id = $_GET["id"];

    mysqli_stmt_bind_param($stmt_complaints, "i", $param_id);

    if (mysqli_stmt_execute($stmt_complaints)) {
        mysqli_stmt_bind_param($stmt_users, "i", $param_id);

        if (mysqli_stmt_execute($stmt_users)) {
            header("location: retrieve_to.php");
        } else {
            echo "ERROR:Could not able to execute $sql_user." . mysqli_error($conn);
        }

    } else {
        echo "ERROR:Could not able to execute $sql_complaints." . mysqli_error($conn);
    }

} else {
    echo "<h3>Looks like you're lost. <a href='http://localhost/final_project/complaint/login.php'>Login</a></h3>";
}

?>
