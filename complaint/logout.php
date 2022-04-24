<?php
    include './bootstrap.php';
    session_start();
    session_destroy();
    unset($_SESSION['user_id']);
    unset($_SESSION['role']);
?>

<br><br><br><br><br>
<h3 class ="text-center">You have been logged out</h3>
<br><br><br>
<div class="container">
    <div class="d-flex justify-content-center">
        <a class ="w-50 btn btn-warning" href="http://localhost/final_project/complaint/login.php">Login</a>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <a class="w-50 btn btn-warning" href="http://localhost/final_project/complaint/register.php">Register</a>
    </div>
</div>
