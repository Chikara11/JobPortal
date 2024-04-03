<?php
session_start();

unset($_SESSION["user"]);
$_SESSION['status'] = "<div class='alert alert-success'>You Logged Out Successfully !</div>";

header("Location: login.php");

?>