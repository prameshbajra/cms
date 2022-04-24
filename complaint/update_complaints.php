<?php
include './bootstrap.php';

// Include config file
require_once "config.php";

session_start();

$id = '';
$user_id = '';
$product_description = '';
$complaint = '';
$status = '';

if (isset($_SESSION['role']) && $_SESSION['role'] == 'admin') {

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
            <div class="container">
                <div style="float:right;">
                    <a class="btn btn-secondary" href="retrieve_to.php">Home</a>
                </div>
                <br><br>
                <form method="post" action="update_complaints_values.php">
                    <input type="hidden" name="id" value="'.$id.'"/><br>
                    <div class="mb-3">
                        <label class="form-label">User id </label>
                        <input name="user_id" disabled class="form-control" value="' . $user_id . '" id="exampleFormControlInput1"
                               placeholder="Enter user id">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Product Description</label>
                        <input name="product_description" type="text" class="form-control" value="' . $product_description . '" id="exampleFormControlInput1"
                               placeholder="Enter the purchased product">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Complaint</label>
                        <input name="complaint" type="text" class="form-control" value="' . $complaint . '" id="exampleFormControlInput1"
                               placeholder="File your complaint">
                   </div>
                   <div class="mb-3">
                        <label class="form-label">Status</label>
                        <input name="status" type="text" class="form-control" value="' . $status . '" id="exampleFormControlInput1"
                               placeholder="">                  
                   </div>
                  <div class="row">
                        <div class="col-6">
                            <button type="submit" class="w-50 btn btn-warning">Update</button>
                        </div>
                  </div>                  
                </form>
            </div>
            </body>
        </html>';
    }
} else {
    echo "<h3>Looks like you're lost. <a href='http://localhost/final_project/complaint/login.php'>Login</a></h3>";
}
?>
