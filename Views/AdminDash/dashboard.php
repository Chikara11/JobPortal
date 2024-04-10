<?php
require_once "../../config.php";
require_once "../../Models/user.php";
session_start();

// // Check if the user isn't logged in, redirect to login page if not
// if (!isset($_SESSION['user'])) {
//     header("Location: ../Auth/login.php");
//     exit();
// }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <title>Dashboard</title>
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <strong>Search for Employee</strong>
                </div>
            </div>
        </div>
    </div>

</body>

</html>