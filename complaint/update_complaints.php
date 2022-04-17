<?php
// Include config file
require_once "config.php";

session_start();

$id = '';
$user_id = '';
$product_description = '';
$complaint = '';
$status = '';

if(isset($_SESSION['role']) && $_SESSION['role'] == 'admin') {

    $param_id = $_GET["id"];

    $sql = "SELECT * FROM complaint WHERE id='$param_id'";

    if ($res = mysqli_query($conn, $sql)) {
        if (mysqli_num_rows($res) > 0) {
            $row = mysqli_fetch_array($res);
            $id = $row[0];
            $user_id = $row[1];
            $product_description = $row[2];
            $complaint = $row[3];
            $status = $row[4];
        }
        echo '
        <html>
            <head>
                <title>Edit Data</title>
            </head>
            <body>
            <a href="retrieve_to.php">Home</a>
            <br><br>
            <form method="post" action="update_complaints_values.php">
                <input type="hidden" name="id" value="'.$id.'"/><br>
            
                <label> User Id -> '.$user_id.'</label>
                <input type="hidden" name="user_id" value="'.$user_id.'"/><br>
                
                <label>Product Description</label>
                <input type="text" name="product_description" value="'.$product_description.'"/><br>
                
                <label>Complaint</label>
                <input type="text" name="complaint" value="'.$complaint.'" /><br>
                
                <label>Status</label>
                <input type="text" name="status" value="'.$status.'" /><br>
                
                <input type="submit" value="Update">
            </form>
            
            </body>
        </html>';
    }
} else {
    echo "<h3>Looks like you're lost. <a href='http://localhost/final_project/complaint/login.php'>Login</a></h3>";
}
?>
