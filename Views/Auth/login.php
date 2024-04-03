<?php
require_once "../../config.php";
require_once "../../Controllers/userC.php";
session_start();
if (isset($_SESSION["user"])) {
    $user = $_SESSION["user"];
    if ($user->getVerifyStatus() == 1) {
        header("Location: ../Profile/profilee.php");
        exit();
    }
}
if (isset($_GET['token'])) {
    $token = $_GET['token'];
    $userController = new UserC();
    $userController->verify_email();
    exit();
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
            <?php
            if ($_SERVER["REQUEST_METHOD"] === "POST") {
                $userController = new UserC();
                $userController->login();
            }
            if (isset($_SESSION['status'])) {
                echo $_SESSION['status'];
                unset($_SESSION['status']);
            }
            ?>
            <form action="login.php" method="post">
                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Email address</label>
                    <input type="email" class="form-control" id="exampleInputEmail1" name="email">
                </div>
                <div class="mb-3">
                    <label for="exampleInputPassword1" class="form-label">Password</label>
                    <input type="password" class="form-control" id="exampleInputPassword1" name="password">
                </div>
                <div class="mb-3">
                    <label for="exampleInputPassword1" class="form-label">Password</label>
                    <a href="password_reset.php" class="float-end">Forgot Your Password?</a>
                </div>
                <div class="mb-3 form-check">
                    <input type="checkbox" class="form-check-input" id="exampleCheck1">
                    <label class="form-check-label" for="exampleCheck1">Check me out</label>
                </div>
                <button type="submit" name="login" class="btn btn-primary">Submit</button>
            </form>
            <br>
            <div>
                <p>Not registered yet <a class="link" href="user_type.php">Register</a></p>
                <p>Not verified yet <a class="link" href="resend_verification.php">Resend</a></p>
            </div>
        </div>
    </section>


</body>

</html>