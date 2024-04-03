<?php
session_start();
require_once "../../config.php";
require_once "../../Models/user.php";

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Handle other form fields for profile update
    header("Location: profilee.php");

    // Handle file upload
    if ($_FILES["cover_upload"]["error"] == UPLOAD_ERR_OK) {
        // Specify the directory where you want to save the uploaded file
        $uploadDirectory = "../../Users_images/CoverImg/";

        // Get the temporary file path
        $tmpFilePath = $_FILES["cover_upload"]["tmp_name"];

        // Generate a unique filename to prevent conflicts
        $fileName = uniqid() . "_" . basename($_FILES["cover_upload"]["name"]);

        // Build the destination path
        $destinationPath = $uploadDirectory . $fileName;

        // Move the uploaded file to the desired directory
        if (move_uploaded_file($tmpFilePath, $destinationPath)) {
            // File was successfully uploaded
            // Update user's cover_img attribute in the database
            $coverImgPath = $destinationPath;

            // Retrieve user ID from session
            $user = new User();
            $user = $_SESSION['user'];
            foreach ($user as $key => $value) {
                if ($key === 'id') {
                    $id = $value;
                }
            }
            try {
                // Establish database connection
                $pdo = config::getConnexion();

                // Retrieve old cover image path from the database
                $sql = "SELECT CoverImg FROM users WHERE id = ?";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([$id]);
                $oldCoverImgPath = $stmt->fetchColumn();

                // Update user's cover_img attribute in the database
                $sql = "UPDATE users SET CoverImg = ? WHERE id = ?";
                $sql_run = $pdo->prepare($sql);
                $sql_run->execute([$coverImgPath, $id]);

                if ($oldCoverImgPath && file_exists($oldCoverImgPath)) {
                    unlink($oldCoverImgPath);
                }

                exit; // Make sure to exit after redirection
            } catch (PDOException $e) {
                // Handle database errors
                echo "Database Error: " . $e->getMessage();
            }
        } else {
            // Error occurred while uploading file
            echo "Error uploading file.";
        }
    } else {
        // Handle file upload errors
        echo "Cover Picture Error: " . $_FILES["cover_upload"]["error"];
    }
    if ($_FILES["profile_pic"]["error"] == UPLOAD_ERR_OK) {
        // Specify the directory where you want to save the uploaded file
        $uploadDirectory = "../../Users_images/ProfilePic/";

        // Get the temporary file path
        $tmpFilePath = $_FILES["profile_pic"]["tmp_name"];

        // Generate a unique filename to prevent conflicts
        $fileName = uniqid() . "_" . basename($_FILES["profile_pic"]["name"]);

        // Build the destination path
        $destinationPath = $uploadDirectory . $fileName;

        // Move the uploaded file to the desired directory
        if (move_uploaded_file($tmpFilePath, $destinationPath)) {
            // File was successfully uploaded
            // Update user's cover_img attribute in the database
            $coverImgPath = $destinationPath;

            // Retrieve user ID from session
            $user = new User();
            $user = $_SESSION['user'];
            foreach ($user as $key => $value) {
                if ($key === 'id') {
                    $id = $value;
                }
            }
            try {
                // Establish database connection
                $pdo = config::getConnexion();

                // Retrieve old profile picture path from the database
                $sql = "SELECT ProfilePic FROM users WHERE id = ?";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([$id]);
                $oldProfilePicPath = $stmt->fetchColumn();

                // Update user's profile_pic attribute in the database
                $sql = "UPDATE users SET ProfilePic = ? WHERE id = ?";
                $sql_run = $pdo->prepare($sql);
                $sql_run->execute([$coverImgPath, $id]);

                // Delete old profile picture if exists
                if ($oldProfilePicPath && file_exists($oldProfilePicPath)) {
                    unlink($oldProfilePicPath);
                }

                exit; // Make sure to exit after redirection
            } catch (PDOException $e) {
                // Handle database errors
                echo "Database Error: " . $e->getMessage();
            }
        } else {
            // Error occurred while uploading file
            echo "Error uploading file.";
        }
    } else {
        // Handle file upload errors
        echo "Profile Picture Error: " . $_FILES["profile_pic"]["error"];
    }



}

?>