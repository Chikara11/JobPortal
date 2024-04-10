<?php
require_once "../../config.php";

// Retrieve job ID from the query parameter
$job_id = $_GET['id'];

// Fetch job details from the database based on the job ID
// Replace 'your_table_name' with the actual table name where job details are stored
// Adjust the query according to your database schema
$pdo = config::getConnexion();
$sql = "SELECT * FROM job_posts WHERE id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$job_id]);
$job = $stmt->fetch(PDO::FETCH_ASSOC);

if ($job) {
    // Extract job details
    $job_title = $job['title'];
    $job_description = $job['description'];
    $job_location = $job['location'];
    $job_date = $job['position_date'];
    $job_type = $job['job_type'];
    $salary = $job['salary'];

    ?>


    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
            integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
        <title>Recruitment website</title>

        <!-- Favicon -->
        <link href="img/favicon.ico" rel="icon">

        <!-- Icon Font Stylesheet -->
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">


        <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
        <link rel="stylesheet" href="style.css">
        <link rel="stylesheet" href="/login2/Public/header.css">


        <title>Website</title>
    </head>

    <body>
        <?php
        $IPATH = $_SERVER["DOCUMENT_ROOT"] . "/login2/Public/";
        include ($IPATH . "header.php") ?>
        <section class="container-xxl bg-white p-0">
            <div class="container-xxl py-5 wow fadeInUp" data-wow-delay="0.1s">
                <div class="container">
                    <div class="row gy-5 gx-4">
                        <div class="col-lg-8">
                            <div class="d-flex align-items-center mb-5">
                                <img class="flex-shrink-0 img-fluid border rounded" src="img/com-logo-2.jpg" alt=""
                                    style="width: 80px; height: 80px;">
                                <div class="text-start ps-4">
                                    <h3 class="mb-3">
                                        <?php echo $job_title; ?>
                                    </h3>
                                    <span class="text-truncate me-3"><i class="fa fa-map-marker-alt text-primary me-2"></i>
                                        <?php echo $job_location; ?>
                                    </span>
                                    <span class="text-truncate me-3"><i class="far fa-clock text-primary me-2"></i>
                                        <?php echo $job_type; ?>
                                    </span></span>
                                    <span class="text-truncate me-0"><i class="far fa-money-bill-alt text-primary me-2"></i>
                                        <?php echo $salary; ?>
                                    </span></span>
                                </div>
                            </div>

                            <div class="mb-5">
                                <h4 class="mb-3">Job description</h4>
                                <p>
                                    <?php echo $job_description; ?>
                                </p>
                                <h4 class="mb-3">Responsibility</h4>
                                <p>Magna et elitr diam sed lorem. Diam diam stet erat no est est. Accusam sed lorem stet
                                    voluptua sit sit at stet consetetur, takimata at diam kasd gubergren elitr dolor</p>
                                <ul class="list-unstyled">
                                    <li><i class="fa fa-angle-right text-primary me-2"></i>Dolor justo tempor duo ipsum
                                        accusam</li>
                                    <li><i class="fa fa-angle-right text-primary me-2"></i>Elitr stet dolor vero clita
                                        labore gubergren</li>
                                    <li><i class="fa fa-angle-right text-primary me-2"></i>Rebum vero dolores dolores elitr
                                    </li>
                                    <li><i class="fa fa-angle-right text-primary me-2"></i>Est voluptua et sanctus at
                                        sanctus erat</li>
                                    <li><i class="fa fa-angle-right text-primary me-2"></i>Diam diam stet erat no est est
                                    </li>
                                </ul>
                                <h4 class="mb-3">Qualifications</h4>
                                <p>Magna et elitr diam sed lorem. Diam diam stet erat no est est. Accusam sed lorem stet
                                    voluptua sit sit at stet consetetur, takimata at diam kasd gubergren elitr dolor</p>
                                <ul class="list-unstyled">
                                    <li><i class="fa fa-angle-right text-primary me-2"></i>Dolor justo tempor duo ipsum
                                        accusam</li>
                                    <li><i class="fa fa-angle-right text-primary me-2"></i>Elitr stet dolor vero clita
                                        labore gubergren</li>
                                    <li><i class="fa fa-angle-right text-primary me-2"></i>Rebum vero dolores dolores elitr
                                    </li>
                                    <li><i class="fa fa-angle-right text-primary me-2"></i>Est voluptua et sanctus at
                                        sanctus erat</li>
                                    <li><i class="fa fa-angle-right text-primary me-2"></i>Diam diam stet erat no est est
                                    </li>
                                </ul>
                            </div>

                            <div class="">
                                <h4 class="mb-4">Apply For The Job</h4>
                                <form>
                                    <div class="row g-3">
                                        <div class="col-12 col-sm-6">
                                            <input type="text" class="form-control" placeholder="Your Name">
                                        </div>
                                        <div class="col-12 col-sm-6">
                                            <input type="email" class="form-control" placeholder="Your Email">
                                        </div>
                                        <div class="col-12 col-sm-6">
                                            <input type="text" class="form-control" placeholder="Portfolio Website">
                                        </div>
                                        <div class="col-12 col-sm-6">
                                            <input type="file" class="form-control bg-white">
                                        </div>
                                        <div class="col-12">
                                            <textarea class="form-control" rows="5" placeholder="Coverletter"></textarea>
                                        </div>
                                        <div class="col-12">
                                            <button class="btn btn-primary w-100" type="submit">Apply Now</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="bg-light rounded p-5 mb-4 wow slideInUp" data-wow-delay="0.1s">
                                <h4 class="mb-4">Job Summery</h4>
                                <p><i class="fa fa-angle-right text-primary me-2"></i>Published On: 01 Jan, 2045</p>
                                <p><i class="fa fa-angle-right text-primary me-2"></i>Vacancy: 123 Position</p>
                                <p><i class="fa fa-angle-right text-primary me-2"></i>Job Nature: Full Time</p>
                                <p><i class="fa fa-angle-right text-primary me-2"></i>Salary: $123 - $456</p>
                                <p><i class="fa fa-angle-right text-primary me-2"></i>Location:
                                    <?php echo $job_location; ?></span>
                                </p>
                                <p class="m-0"><i class="fa fa-angle-right text-primary me-2"></i>Date Line: 01 Jan, 2045
                                </p>
                            </div>
                            <div class="bg-light rounded p-5 wow slideInUp" data-wow-delay="0.1s">
                                <h4 class="mb-4">Company Detail</h4>
                                <p class="m-0">Ipsum dolor ipsum accusam stet et et diam dolores, sed rebum sadipscing elitr
                                    vero dolores. Lorem dolore elitr justo et no gubergren sadipscing, ipsum et takimata
                                    aliquyam et rebum est ipsum lorem diam. Et lorem magna eirmod est et et sanctus et, kasd
                                    clita labore.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>






        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    </body>

    </html>
    <?php
} else {
    echo "Job not found";
}
?>