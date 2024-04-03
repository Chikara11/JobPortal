<?php
require_once "../../config.php";
require_once "../../Controllers/userC";
session_start();


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Form</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="stylee.css">
</head>

<body class="auth">
    <nav class="navbar navbar-expand-lg fixed-top">
        <div class="container-fluid d-flex justify-content-between ">
            <a class="navbar-brand me-auto" href="../HomePage/Home.php">Logo</a>
            <span class="navbar-text me-3">Looking to hire talent?</span>
            <a href="registerrecruiter.php" class="linked-text">Join as a recruiter</a>
        </div>
    </nav>
    <section class="bg-section-register">
        <div class="container">
            <?php
            if ($_SERVER["REQUEST_METHOD"] === "POST") {
                $userController = new UserC();
                $user_type = "employee";
                $userController->register($user_type);
            }
            ?>
            <h2>
                <center>Sign up to find work you love</center>
            </h2>
            <form action="registerWorker.php" method="post">
                <div class="mb-3">
                    <label for="FullnameInput" class="form-label">Fullname</label>
                    <input type="text" name="fullname" class="form-control" id="FullnameInput">
                </div>
                <div class="mb-3">
                    <label for="EmailInput" class="form-label">Email address</label>
                    <input type="email" name="email" class="form-control" id="EmailInput">
                    <div id="emailHelp" class="form-text">We'll never share your email with anyone else.
                    </div>
                </div>
                <div class="mb-3">
                    <label for="PhoneInput" class="form-label">Phone Number</label>
                    <input type="tel" name="tel" class="form-control" id="PhoneInput" placeholder="(+216) ">
                </div>
                <div class="mb-3">
                    <label for="PasswordInput" class="form-label">Password</label>
                    <input type="password" name="password" class="form-control"
                        placeholder="Password (8 or more charachters)" id="PasswordInput">
                </div>
                <div class="mb-3">
                    <label for="CPasswordInput" class="form-label">Confirm Password</label>
                    <input type="password" name="confirm_password" class="form-control" id="CPasswordInputs">
                </div>
                <div class="mb-3 form-check">
                    <input type="checkbox" class="form-check-input" id="exampleCheck1">
                    <label class="form-check-label" for="exampleCheck1">Check me out</label>
                </div>
                <input type="hidden" name="user_type" value="employee">
                <button type="submit" name="submit" class="btn btn-primary">Submit</button>
            </form>
            <br>
            <div>
                <p>Already registered? <a class="link" href="login.php">Login</a></p>
            </div>
        </div>
    </section>

</body>

</html>