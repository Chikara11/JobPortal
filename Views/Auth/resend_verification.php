<?php
require_once "../../config.php";
require_once "../../Controllers/userC.php";
session_start();
if (isset($_SESSION["user"])) {
    header("Location: ../HomePage/home.php");
}
if (isset($_POST["resend"])) {
    $userController = new userC();
    $userController->resend_emaill();
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login form</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="stylee.css">
</head>

<body class="auth">
    <section class="bg-section">
        <nav class="navbar navbar-expand-lg fixed-top">
            <div class="container-fluid">
                <a class="navbar-brand me-auto" href="../HomePage/Home.php">Logo</a>
            </div>
        </nav>

        <div class="container">
            <h5>
                <center>Resend Email Verification</center>
            </h5>
            <form action="" method="post">
                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Email address</label>
                    <input type="email" class="form-control" id="exampleInputEmail1" name="email">
                </div>
                <button type="submit" name="resend" class="btn btn-primary">Submit</button>
            </form>
            <br>
        </div>
    </section>


</body>

</html>