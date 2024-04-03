<?php
require_once "../../config.php";
require_once "../../Models/user.php";
session_start();

// Check if the user isn't logged in, redirect to login page if not
if (!isset($_SESSION['user'])) {
    header("Location: ../Auth/login.php");
    exit();
}

$user = $_SESSION["user"];
$email = $user->getEmail();

// Fetch user data from the database based on the logged-in user
$pdo = config::getConnexion();
$sql = "SELECT * FROM users WHERE email = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$email]);
if ($stmt->rowCount() > 0) {
    // Fetch user data
    $userData = $stmt->fetch(PDO::FETCH_ASSOC);
} else {
    // If user doesn't exist, redirect to login page
    header("Location: ../Auth/login.php");
    exit(); // Terminate script execution after redirection
}

$country_sql = "SELECT name FROM countries WHERE id = ?";
$country_sql_run = $pdo->prepare($country_sql);
$country_sql_run->execute([$userData['country_id']]);
$countryId = $country_sql_run->fetchColumn();


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" />
    <title>Document</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="stylee.css">
</head>

<body>
    <?php
    $IPATH = $_SERVER["DOCUMENT_ROOT"] . "/login2/Public/";
    include ($IPATH . "header.php")
        ?>
    <div class="profile-container">
        <!-- Profile page content here -->
        <div class="profile_header">
            <!-- Display user's profile picture and cover image -->
            <div class="profile_images">
                <img src="<?php echo $userData['CoverImg']; ?>" class="cover-img">
                <div class="pdp_container">
                    <img src="<?php echo $userData['ProfilePic']; ?>" alt="profile pic">
                    <span></span>
                </div>
            </div>
            <div class="profile_description">
                <div class="edit">
                    <a href="profile_edit.php"><img src="../../Public/images/pen.png" alt="Freelancer"></a>
                </div>
                <h1>
                    <?php echo $userData['fullname']; ?>
                </h1>
                <!-- Add user's description and social media links here -->
                <div class="social_media">
                    <ul>
                        <li><i class="fab fa-twitter"></i></li>
                        <li><i class="fab fa-pinterest"></i></li>
                        <li><i class="fab fa-facebook"></i></li>
                        <li><i class="fab fa-dribbble"></i></li>
                    </ul>
                </div>
                <h2>About :</h2>
                <div class="about_section">
                    <?php echo $userData['about']; ?>
                </div>
            </div>
        </div>
        <div class="profile_info">
            <div class="info_col">
                <div class="profile_intro">
                    <ul>
                        <li><img src="../../Public/images/camera.png">
                            <?php echo $userData['school']; ?>
                        </li>
                        <li><img src="../../Public/images/camera.png">
                            <?php echo $countryId; ?>,
                            <?php
                            echo $userData['City']; ?>
                        </li>
                        <li><img src="../../Public/images/camera.png">
                            <?php echo $userData['education']; ?>
                        </li>
                        <li><img src="../../Public/images/camera.png">Something</li>
                        <li><img src="../../Public/images/camera.png">Something</li>
                    </ul>
                </div>

            </div>
            <div class="post_col">
                <div class="write-post-container">
                    <div class="user-profile">
                        <img src="<?php echo $userData['ProfilePic']; ?>" alt="profile pic">
                        <div>
                            <p>
                                <?php echo $userData['fullname']; ?>
                            </p>
                            <small>Public <i class="fas fa-caret-down"></i></small>
                        </div>
                    </div>
                    <div class="post-input-container">
                        <textarea rows="3" placeholder="What's on ur mind?"></textarea>
                        <div class="add-post-links">
                            <a href="#"><img src="../../Public/images/camera.png" alt="">Live Video</a>
                            <a href="#"><img src="../../Public/images/image.png" alt="">Photo/Video</a>
                            <a href="#"><img src="../../Public/images/feedback.png" alt="">Feeling/Activity</a>
                        </div>
                    </div>

                </div>
                <div class="post-container">
                    <div class="post-row">
                        <div class="user-profile">
                            <img src="<?php echo $userData['ProfilePic']; ?>" alt="profile pic">
                            <div>
                                <p>
                                    <?php echo $userData['fullname']; ?>
                                </p>
                                <span>March 21 2024, 3:36 pm</span>
                            </div>
                        </div>
                        <a href="#"><i class="fas fa-ellipsis-v"></i></a>
                    </div>
                    <p class="post-text">All alone in peace</p>
                    <img class="post_img" src="../../Public/images/1.jpg">

                </div>
                <div class="post-container">
                    <div class="post-row">
                        <div class="user-profile">
                            <img src="<?php echo $userData['ProfilePic']; ?>" alt="profile pic">
                            <div>
                                <p>
                                    <?php echo $userData['fullname']; ?>
                                </p>
                                <span>March 21 2024, 3:36 pm</span>
                            </div>
                        </div>
                        <a href="#"><i class="fas fa-ellipsis-v"></i></a>
                    </div>
                    <p class="post-text">All alone in peace</p>
                    <img class="post_img" src="../../Public/images/2.jpg">

                </div>
                <div class="post-container">
                    <div class="post-row">
                        <div class="user-profile">
                            <img src="<?php echo $userData['ProfilePic']; ?>" alt="profile pic">
                            <div>
                                <p>
                                    <?php echo $userData['fullname']; ?>
                                </p>
                                <span>March 21 2024, 3:36 pm</span>
                            </div>
                        </div>
                        <a href="#"><i class="fas fa-ellipsis-v"></i></a>
                    </div>
                    <p class="post-text">All alone in peace</p>
                    <img class="post_img" src="../../Public/images/3.jpg">

                </div>
                <div class="post-container">
                    <div class="post-row">
                        <div class="user-profile">
                            <img src="<?php echo $userData['ProfilePic']; ?>" alt="profile pic">
                            <div>
                                <p>
                                    <?php echo $userData['fullname']; ?>
                                </p>
                                <span>March 21 2024, 3:36 pm</span>
                            </div>
                        </div>
                        <a href="#"><i class="fas fa-ellipsis-v"></i></a>
                    </div>
                    <p class="post-text">All alone in peace</p>
                    <img class="post_img" src="../../Public/images/3.jpg">

                </div>
            </div>


        </div>
    </div>
    <script src="script.js"></script>
</body>

</html>