<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <title>Signup Page</title>
    <link rel="stylesheet" href="stylee.css">
</head>

<body>
    <header>
        <nav class="navbar navbar-expand-lg fixed-top">
            <div class="container-fluid">
                <a class="navbar-brand me-auto" href="../HomePage/Home.html">Logo</a>
            </div>
        </nav>
    </header>
    <section class="bg-section">
        <div class="container">
            <h1> Join as a Recruiter or Worker </h1>
            <fieldset>
                <div class="signup-options">
                    <div class="signup-option">
                        <input type="radio" name="user-type" id="client-option">
                        <label for="client-option">
                            <img src="../../Public/images/employer.png" alt="Client">
                            <div>
                                <h4>Find the perfect talent for your project</h4>
                            </div>
                        </label>
                    </div>
                    <div class="signup-option">
                        <input type="radio" name="user-type" id="freelancer-option">
                        <label for="freelancer-option">
                            <img src="../../Public/images/employee.png" alt="Freelancer">
                            <div>
                                <h4>Create an account as a freelancer</h4>
                            </div>
                        </label>
                    </div>
                </div>
            </fieldset>
            <div class="aa">
                <button id="signup-button" class="disabled">Create Account</button>
                <p id="signup-message">Already have an account? <a class="link" href="login.php">Log In</a> </p>
            </div>
        </div>

    </section>
    <script src="event.js"></script>
</body>

</html>