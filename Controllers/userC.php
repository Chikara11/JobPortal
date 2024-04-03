<?php

$config = parse_ini_file("../../config.ini", true);


require_once "../../config.php";
require_once "../../Models/user.php";

require_once "PHPMailer/src/PHPMailer.php";
require_once "PHPMailer/src/SMTP.php";
require_once "PHPMailer/src/Exception.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class UserC
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = config::getConnexion();
    }

    private function validateUser($email, $password)
    {
        $login_query = "SELECT * FROM users WHERE email = :email";
        $login_query_run = $this->pdo->prepare($login_query);
        $login_query_run->execute(['email' => $email]);
        $user = $login_query_run->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            // Check if the 'password' key exists in the $user array
            if (array_key_exists('password', $user) && password_verify($password, $user["password"])) {
                if ($user['verify_status'] == "1") {
                    return $user;
                } else {
                    $_SESSION['status'] = "<div class='alert alert-danger'>Please Verify your Email Address to Login</div>";
                    header("Location: login.php");
                    exit(0);
                }
            } else {
                // Invalid password
                return false;
            }
        } else {
            // User not found
            return false;
        }
    }

    private function sendemail_verify($fullname, $email, $verify_token)
    {
        global $config;
        $mail = new PHPMailer(true);
        //Server settings
        // $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host = 'smtp.gmail.com';                     //Set the SMTP server to send through
        $mail->SMTPAuth = true;                                   //Enable SMTP authentication
        $mail->Username = $config['email']['ADDRESS'];                  //SMTP username
        $mail->Password = $config['email']['PASSWORD'];                         //SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
        $mail->Port = 465;                                //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

        //Recipients
        $mail->setFrom('', 'Mailer');
        // $mail->addAddress($email, $fullname);     //Add a recipient
        $mail->addAddress($email);               //Name is optional
        // $mail->addReplyTo('info@example.com', 'Information');
        // $mail->addCC('cc@example.com');
        // $mail->addBCC('bcc@example.com');

        // //Attachments
        // $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
        // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = ' Email Verification from HireMe';

        $email_template = "
            <h2>You have registered with HireMe</h2>
            <h5>Verify your email address to login with the link given below</h5>
            <br></br>
            <a href='http://localhost/login2/Views/Auth/login.php?token=$verify_token'>Click Me</a>
        ";

        $mail->Body = $email_template;
        // $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

        $mail->send();
        // echo 'Message has been sent';
    }

    public function verify_email()
    {
        if (isset($_GET['token'])) {
            $token = $_GET['token'];
            $verify_query = "SELECT verifyToken,verify_status FROM users WHERE verifyToken= ? LIMIT 1";
            $verify_query_run = $this->pdo->prepare($verify_query);
            $verify_query_run->execute([$token]);

            if ($verify_query_run->rowCount() > 0) {
                $row = $verify_query_run->fetch(PDO::FETCH_ASSOC);
                $clicked_token = $row["verifyToken"];
                $update_query = "UPDATE users SET verify_status='1' WHERE verifyToken=? LIMIT 1";
                $update_query_run = $this->pdo->prepare($update_query);
                $update_query_run->execute([$clicked_token]);

                if ($update_query_run) {
                    $_SESSION['status'] = "<div class='alert alert-success'>Your Account has been verified Successfully !</div>";
                    header("Location: login.php");
                    exit(0);
                } else {
                    $_SESSION['status'] = "<div class='alert alert-danger'>Verification Failed !</div>";
                    header("Location: login.php");
                }
            } else {
                $_SESSION['status'] = "<div class='alert alert-danger'>This token does not exist</div>";
                header("Location: login.php");
            }

        } else {
            $_SESSION['status'] = "<div class='alert alert-danger'>Not Allowed</div>";
            header("Location: login.php");
        }
    }

    public function resend_email($fullname, $email, $verify_token)
    {
        global $config;
        $mail = new PHPMailer(true);
        //Server settings
        // $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host = 'smtp.gmail.com';                     //Set the SMTP server to send through
        $mail->SMTPAuth = true;                                   //Enable SMTP authentication
        $mail->Username = $config['email']['ADDRESS'];                  //SMTP username
        $mail->Password = $config['email']['PASSWORD'];                                //SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
        $mail->Port = 465;                                //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

        //Recipients
        $mail->setFrom('', 'Mailer');
        // $mail->addAddress($email, $fullname);     //Add a recipient
        $mail->addAddress($email);               //Name is optional
        // $mail->addReplyTo('info@example.com', 'Information');
        // $mail->addCC('cc@example.com');
        // $mail->addBCC('bcc@example.com');

        // //Attachments
        // $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
        // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = 'Resend - Email Verification from HireMe';

        $email_template = "
            <h2>You have registered with HireMe</h2>
            <h5>Verify your email address to login with the link given below</h5>
            <br></br>
            <a href='http://localhost/login2/Views/Auth/login.php?token=$verify_token'>Click Me</a>
        ";

        $mail->Body = $email_template;
        // $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

        $mail->send();
        // echo 'Message has been sent';
    }

    public function resend_emaill()
    {
        if (isset($_POST["resend"])) {
            if (!empty(trim($_POST['email']))) {
                $email = $_POST['email'];
                $sql = "SELECT * FROM users WHERE email = ? LIMIT 1";
                $verification_check = $this->pdo->prepare($sql);
                $verification_check->execute([$email]);
                if ($verification_check->rowCount() > 0) {
                    $row = $verification_check->fetch(PDO::FETCH_ASSOC);
                    if ($row['verify_status'] == "0") {
                        $this->resend_email($row["fullname"], $row["email"], $row["verifyToken"]);
                        $_SESSION['status'] = "<div class='alert alert-danger'>Verification email link has been sent to your email address!</div>";
                        header("Location: login.php");
                        exit(0);

                    } else {
                        $_SESSION['status'] = "<div class='alert alert-danger'>Email already verified. Please login</div>";
                        header("Location: login.php");
                        exit(0);
                    }
                } else {
                    $_SESSION['status'] = "<div class='alert alert-danger'>Email is not registered. Please Register now!</div>";
                    header("Location: user_type.php");
                }

            } else {
                $_SESSION['status'] = "<div class='alert alert-danger'>Please fill in the Email field</div>";
                header("Location: resend_verification.php");
                exit(0);
            }
        }
    }

    public function send_password_reset($fullname, $email, $verify_token)
    {
        global $config;
        $mail = new PHPMailer(true);
        //Server settings
        // $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host = 'smtp.gmail.com';                     //Set the SMTP server to send through
        $mail->SMTPAuth = true;                                   //Enable SMTP authentication
        $mail->Username = $config['email']['ADDRESS'];                  //SMTP username
        $mail->Password = $config['email']['PASSWORD'];                                //SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
        $mail->Port = 465;                                //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

        //Recipients
        $mail->setFrom($config['email']['ADDRESS'], $fullname);
        // $mail->addAddress($email, $fullname);     //Add a recipient
        $mail->addAddress($email);               //Name is optional
        // $mail->addReplyTo('info@example.com', 'Information');
        // $mail->addCC('cc@example.com');
        // $mail->addBCC('bcc@example.com');

        // //Attachments
        // $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
        // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = 'Password reset';

        $email_template = "
            <h2>Hello</h2>
            <h5>You are receiving this email because we received a password reset request for your account</h5>
            <br></br>
            <a href='http://localhost/login2/Views/Auth/password_change.php?token=$verify_token&email=$email'>Click Me</a>
        ";

        $mail->Body = $email_template;
        // $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

        $mail->send();
        // echo 'Message has been sent';
    }

    public function reset_password()
    {
        if (isset($_POST["password_reset"])) {
            if (!empty(trim($_POST['email']))) {
                $get_email = $_POST['email'];
                $sql = "SELECT * FROM users WHERE email = ? LIMIT 1";
                $check_email = $this->pdo->prepare($sql);
                $check_email->execute([$get_email]);

                $token = md5(rand());

                if ($check_email->rowCount() > 0) {
                    $row = $check_email->fetch(PDO::FETCH_ASSOC);
                    $email = $row["email"];
                    $fullname = $row["fullname"];

                    $update_token = "UPDATE users SET verifyToken = ? WHERE email = ? LIMIT 1";
                    $update_token_run = $this->pdo->prepare($update_token);
                    $update_token_run->execute([$token, $email]);

                    if ($update_token_run) {
                        $this->send_password_reset($fullname, $email, $token);
                        $_SESSION['status'] = "<div class='alert alert-success'>Password reset link has been sent!</div>";
                        header("Location: password_reset.php");
                        exit(0);

                    } else {
                        $_SESSION['status'] = "<div class='alert alert-danger'>Something went wrong</div>";
                        header("Location: password_reset.php");
                        exit(0);
                    }

                } else {
                    $_SESSION['status'] = "<div class='alert alert-danger'>No Email found</div>";
                    header("Location: password_reset.php");
                    exit(0);

                }

            } else {
                $_SESSION['status'] = "<div class='alert alert-danger'>Please fill in the Email field</div>";
                header("Location: password_reset.php");
                exit(0);
            }
        }
        if (isset($_POST['password_update'])) {
            $get_email = $_POST['email'];
            $get_password = $_POST['new_password'];
            $get_passwordC = $_POST['confirm_password'];
            $token = $_POST['password_token'];

            if (!empty($token)) {
                if (!empty($get_email) && !empty($get_password) && !empty($get_passwordC)) {
                    $pdo = config::getConnexion();
                    $check_token = "SELECT verifyToken FROM user WHERE verifyToken= ? LIMIT 1";
                    $check_token_run = $pdo->prepare($check_token);
                    $check_token_run->execute([$token]);
                    if ($check_token_run->rowCount() > 0) {
                        if ($get_password == $get_passwordC) {
                            $passwordHash = password_hash($get_password, PASSWORD_DEFAULT);
                            $update_password = "UPDATE users SET password='$passwordHash' WHERE verifyToken='$token' LIMIT 1";
                            $update_password_run = $pdo->prepare($update_password);
                            $update_password_run->execute();

                            if ($update_password_run) {
                                $new_token = md5(rand());
                                $update_newToken = "UPDATE user SET verifyToken='$new_token' WHERE verifyToken='$token' LIMIT 1";
                                $update_newToken_run = $pdo->prepare($update_newToken);
                                $update_newToken_run->execute();
                                $_SESSION['status'] = "<div class='alert alert-success'>New Password successfully update! </div>";
                                header("Location: login.php?");
                                exit(0);
                            } else {
                                $_SESSION['status'] = "<div class='alert alert-danger'>Did not update password. Something went wrong! </div>";
                                header("Location: password_change.php?token=$token&email=$get_email");
                                exit(0);
                            }
                        } else {
                            $_SESSION['status'] = "<div class='alert alert-danger'>Password and confirm password does not match </div>";
                            header("Location: password_change.php?token=$token&email=$get_email");
                            exit(0);
                        }
                    } else {
                        $_SESSION['status'] = "<div class='alert alert-danger'>Invalid token </div>";
                        header("Location: password_change.php?token=$token&email=$get_email");
                        exit(0);
                    }
                } else {
                    $_SESSION['status'] = "<div class='alert alert-danger'>All fields are Mandatory </div>";
                    header("Location: password_change.php?token=$token&email=$get_email");
                    exit(0);
                }

            } else {
                $_SESSION['status'] = "<div class='alert alert-danger'>No token available</div>";
                header("Location: password_change.php");
                exit(0);
            }
        }
    }

    public function login()
    {
        try {
            if (isset($_POST["login"])) {
                $email = $_POST["email"];
                $password = $_POST["password"];

                // Create an instance of the User class
                $userModel = new User();

                // Validate user credentials
                $user = $this->validateUser($email, $password);

                if ($user) {
                    // Set user data in the User object
                    $userModel->setId($user['id']);
                    $userModel->setFullname($user['fullname']);
                    $userModel->setEmail($user['email']);
                    $userModel->setPassword($user['password']);
                    $userModel->setVerifyToken($user['verifyToken']);

                    session_start();
                    $_SESSION["user"] = $userModel; // Store User object in session
                    header("Location: ../Profile/profilee.php");
                    die();
                } else {
                    echo "<div class='alert alert-danger'>Invalid email or password</div>";
                }
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    public function register($user_type)
    {
        try {
            if (isset($_POST["submit"])) {
                $fullname = $_POST["fullname"];
                $email = $_POST["email"];
                $tel = $_POST["tel"];
                $password = $_POST["password"];
                $confirm_password = $_POST["confirm_password"];
                $verify_token = md5(rand());

                // Validate user input
                $error = $this->validateRegistrationInput($fullname, $email, $password, $confirm_password);
                if (!empty($error)) {
                    foreach ($error as $msg) {
                        echo "<div class='alert alert-danger'>$msg</div>";
                    }
                    return;
                }

                // Hash the password
                $passwordHash = password_hash($password, PASSWORD_DEFAULT);

                // Create a new User instance based on user type
                $newUser = new User($fullname, $email, $passwordHash, $tel, $verify_token, $user_type);
                // Check if email already exists
                $pdo = config::getConnexion();
                $sql = "SELECT * FROM users WHERE email = ?";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([$email]);
                $existingUser = $stmt->fetch(PDO::FETCH_ASSOC);
                if ($existingUser) {
                    echo "<div class='alert alert-danger'>Email already exists</div>";
                    return;
                }

                // Save the new user to the database
                $this->saveUserToDatabase($newUser);

                // Send verification email
                $this->sendemail_verify($fullname, $email, $verify_token);

                $_SESSION['status'] = "<div class='alert alert-success'>You are registered successfully! Please verify your email address.</div>";
                header("Location: ../../Views/Auth/login.php");
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }


    private function validateRegistrationInput($fullname, $email, $password, $confirm_password)
    {
        $error = [];

        if (empty($fullname) || empty($email) || empty($password) || empty($confirm_password)) {
            $error[] = "All fields are required";
        } else {
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $error[] = "Email is not valid";
            } else {
                if (strlen($password) < 8) {
                    $error[] = "Password must be at least 8 characters long";
                } else {
                    if ($password !== $confirm_password) {
                        $error[] = "Passwords do not match";
                    }
                }
            }
        }

        return $error;
    }

    private function saveUserToDatabase($user)
    {
        $pdo = config::getConnexion();
        $sql = "INSERT INTO users (fullname, email, password, phone_num, verifyToken, userType) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$user->getFullname(), $user->getEmail(), $user->getPassword(), $user->getPhoneNum(), $user->getVerifyToken(), $user->getUserType]);
    }

    public function logout()
    {
        session_start();

        unset($_SESSION["user"]);
        $_SESSION['status'] = "<div class='alert alert-success'>You Logged Out Successfully !</div>";

        header("Location: ../Views/Auth/login.php");
    }

    public function edit_profile($email)
    {
        try {
            if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["save"])) {
                // Handle other form fields for profile update
                $fullname = $_POST["Fullname"];
                $tel = $_POST["Phone_num"];
                $about = $_POST["about"];
                $educationLvl = $_POST["EducationLvl"];
                $school = $_POST["Education_ins"];
                $city = $_POST["city"];
                $country = $_POST["country"];


                // Handle cover picture upload
                $coverImgPath = $this->uploadFile($_FILES["cover_upload"], "../../Users_images/CoverImg/", $email);

                // Handle profile picture upload
                $profilePicPath = $this->uploadFile($_FILES["profile_pic"], "../../Users_images/ProfilePic/", $email);

                // Establish database connection
                $pdo = config::getConnexion();

                //get the country id
                $country_sql = "SELECT id FROM countries WHERE name = ?";
                $country_sql_run = $pdo->prepare($country_sql);
                $country_sql_run->execute([$country]);
                $countryId = $country_sql_run->fetchColumn();

                // Build and execute the SQL query to update the user's profile
                $sql = "UPDATE users SET fullname = ?, phone_num = ?, about = ?, education = ?, school = ?, country_id = ?, City = ?";
                $params = [$fullname, $tel, $about, $educationLvl, $school, $countryId, $city];

                // Append cover image path if available
                if ($coverImgPath) {
                    $sql .= ", CoverIMG = ?";
                    $params[] = $coverImgPath;
                }

                // Append profile picture path if available
                if ($profilePicPath) {
                    $sql .= ", ProfilePic = ?";
                    $params[] = $profilePicPath;
                }

                // Add WHERE clause for email
                $sql .= " WHERE email = ?";
                $params[] = $email;

                // Prepare and execute the query
                $stmt = $pdo->prepare($sql);
                $stmt->execute($params);

                // Redirect to profile page after successful update
                header("Location: ../../Views/Profile/profilee.php");
                exit; // Exit after redirection
            }
        } catch (PDOException $e) {
            // Handle database errors
            echo "Database Error: " . $e->getMessage();
        }
    }

    // Function to handle file upload
    private function uploadFile($file, $uploadDirectory, $email)
    {
        $filePath = null;
        if ($file["error"] == UPLOAD_ERR_OK) {
            // Generate a unique filename to prevent conflicts
            $fileName = uniqid() . "_" . basename($file["name"]);

            // Build the destination path
            $filePath = $uploadDirectory . $fileName;

            // Retrieve old profile picture path from the database
            $pdo = config::getConnexion();
            $sql = "SELECT ProfilePic FROM users WHERE email = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$email]);
            $oldProfilePicPath = $stmt->fetchColumn();

            // Move the uploaded file to the desired directory
            if (!move_uploaded_file($file["tmp_name"], $filePath)) {
                // Error occurred while uploading file
                echo "Error uploading file.";
                $filePath = null; // Reset filePath if upload fails
            }

            // Delete old profile picture if exists
            if ($oldProfilePicPath && file_exists($oldProfilePicPath)) {
                unlink($oldProfilePicPath);
            }

        }
        return $filePath;
    }






}

?>