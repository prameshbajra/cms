<?php
session_start();
session_destroy();
unset($_SESSION['user_id']);
unset($_SESSION['role']);
echo 'You have been logged out.<br><br><br>';
echo '<a type="button" href="http://localhost/final_project/complaint/login.php">Login</a> <br> ';
echo '<a type="button" href="http://localhost/final_project/complaint/register.php">Register</a>';
?>