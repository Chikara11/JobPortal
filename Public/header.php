<?php
require_once "/xampp/htdocs/login2/config.php";
$paths = config::getPaths();


if (isset($_POST['logout'])) {
    header("Location: ../Views/Auth/logout.php");
    exit();
}

?>

<header>

    <nav class="navbar navbar-expand-lg fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand me-auto" href="<?php echo $paths['home']; ?>">Logo</a>
            <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar"
                aria-labelledby="offcanvasNavbarLabel">
                <div class="offcanvas-header">
                    <h5 class="offcanvas-title" id="offcanvasNavbarLabel">Logo</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>
                <div class="offcanvas-body">
                    <ul class="navbar-nav justify-content-center flex-grow-1 pe-3">
                        <li class="nav-item">
                            <a class="nav-link active mx-lg-2" aria-current="page" href="#">Premium</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link mx-lg-2" href="#">About</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link mx-lg-2" href="<?php echo $paths['jobs']; ?>">Job
                                Listings</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link mx-lg-2" href="#">Forum</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link mx-lg-2" href="#">Courses</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                Explore
                            </a>
                            <ul class="dropdown-menu mx-lg-2">
                                <li><a class="dropdown-item" href="#">Discover</a></li>
                                <li><a class="dropdown-item" href="#">Community</a></li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li><a class="dropdown-item" href="#">Guides</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
            <?php if (isset($_SESSION["user"])): ?>
                <form method="post" action="../../Public\header.php">
                    <button name="logout" type="submit" class="login-button">Log Out</button>
                </form>
            <?php else: ?>
                <a href="../Auth/login.php" class="login-button">Login</a>
                <a href="../Auth/user_type.php" class="login-button">Sign Up</a>
            <?php endif; ?>
            <button class="navbar-toggler pe-0" type="button" data-bs-toggle="offcanvas"
                data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

        </div>

    </nav>
</header>