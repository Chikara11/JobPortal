<?php
// deleteUser.php

// Include the necessary files and classes
require_once "../../config.php";
require_once "../../Controllers/userC.php";

// Check if the email is provided in the POST request
if (isset($_POST['email'])) {
    // Get the email from the POST request
    $email = $_POST['email'];

    // Create an instance of the UserC class
    $userController = new UserC();

    // Call the delete_user function to delete the user
    $deleted = $userController->delete_user($email);

    // Check if the user was successfully deleted
    if ($deleted) {
        // Redirect back to the previous page
        header("Location: dashboard.php");
        exit(); // Ensure no further code execution after redirection
    } else {
        // Handle deletion failure (e.g., display an error message)
        echo "Failed to delete user.";
    }
} else {
    // If email is not provided, redirect to an error page or show an error message
    echo "Email not provided.";
}
?>