<?php
session_start();

if (isset($_SESSION['role']) && $_SESSION['role'] == 'admin') {
    header("location: retrieve_to.php");
} elseif (isset($_SESSION['role']) && $_SESSION['role'] == 'customer') {
    header("location: create.php");
} else {
    header("location: login.php");
}
?>