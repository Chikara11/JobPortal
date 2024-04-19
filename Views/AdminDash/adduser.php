<?php
require_once "../../config.php";
require_once "../../Controllers/userC.php";

// Check if the form is submitted
if (isset($_POST["submit"])) {
    // Get form data
    $fullname = $_POST["fullname"];
    $email = $_POST["email"];
    $tel = $_POST["tel"];
    $password = $_POST["password"];

    // Create an instance of the UserC class
    $userController = new UserC();

    // Add user to the database
    $userController->add_user($fullname, $email, $tel, $password);
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add User</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        input[type="text"],
        input[type="email"],
        input[type="tel"],
        input[type="password"],
        input[type="submit"] {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            margin-bottom: 10px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        input[type="submit"] {
            background-color: #009933;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #008c2d;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>Add User</h2>
        <form action="dashboard.php
        " method="POST">
            <label for="fullname">Full Name:</label>
            <input type="text" id="fullname" name="fullname" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>

            <label for="tel">Telephone:</label>
            <input type="tel" id="tel" name="tel" required>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>

            <input type="submit" name="submit" value="Add User">
        </form>
    </div>
</body>

</html>