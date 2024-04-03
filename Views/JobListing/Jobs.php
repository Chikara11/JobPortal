<?php
require_once "../../config.php";
require_once "../../Controllers/jobC.php";

// Create a new instance of the JobC class
$jobController = new JobC();

// Set the page number and number of jobs per page
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$jobsPerPage = 10;

// Calculate the offset
$offset = ($page - 1) * $jobsPerPage;

// Get job listings for the current page
$jobs = $jobController->getJobs($offset, $jobsPerPage);

// Get total number of jobs
$totalJobs = $jobController->getTotalJobs();

// Calculate total number of pages
$totalPages = ceil($totalJobs / $jobsPerPage);
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
    include ($IPATH . "header.php")
        ?>
    <form action="" method="GET" class="formContainer border-b border-gray-/10">
        <div class="grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-12 ">
            <div class="sm:col-span-5 flex">
                <label class="block text-lg font-medium leading-6 text-gray-900 mt-3 mr-2">What</label>
                <div class="mt-2 w-full">
                    <input type="text" name="what" id="what" autocomplete="off" value="Developer"
                        class="p-2 block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6 ">
                </div>
            </div>

            <div class="sm:col-span-5 flex">
                <label class="block text-lg font-medium leading-6 text-gray-900 mt-3 mr-2">Where</label>
                <div class="mt-2 w-full">
                    <input type="text" name="Education_ins" id="Education_ins" autocomplete="Education-Institution"
                        value="Tunis"
                        class="p-2 block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                </div>
            </div>
            <div class="sm:col-span-2 mt-2">
                <button class="p-2 px-4 rounded-md bg-indigo-600 text-white">Search jobs</button>
            </div>
        </div>
        <div class="recommendation_list mt-2">
            <span>Similar searches</span>
            <ul class=" flex">
                <li class="pl-3"><a href=""></a>Developer</li>
                <li class="pl-3"><a href=""></a>Software engineer</li>
                <li class="pl-3"><a href=""></a>Graphic designer</li>
                <li class="pl-3"><a href=""></a>Digital marketer</li>
                <li class="pl-3"><a href=""></a>developer</li>
                <li class="pl-3"><a href=""></a>developer</li>
            </ul>
        </div>

    </form>

    <div class="postContainer">
        <aside class="search_filter">
            <div class="mb">
                <header>
                    <h3 class=" h3 mb-3">Filter your search</h3>
                </header>
                <div class="salary_range mb-4">
                    <div class="header">
                        <h4 class="h4">Salary Range</h4>
                    </div>
                    <div>
                        <div>
                            <label for="salaryFrom">From:</label>
                            <select
                                class="p-2 block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:max-w-xs sm:text-sm sm:leading-6"
                                name="salaryFrom" id="salaryFrom" aria-label="Select a salary from ">
                                <option value="0" selected="">$ Any</option>
                                <option value="1000">Up to $1000</option>
                                <option value="1500">$1500</option>
                                <option value="2000">$2000</option>
                                <option value="2500">$2500</option>
                                <option value="3000">$3000</option>
                                <option value="5000">$5000</option>
                                <option value="6000">$6000</option>
                                <option value="8000">$8000</option>
                                <option value="100000">$100000+</option>
                            </select>
                        </div>
                        <div></div>
                    </div>
                    <div>
                        <div>
                            <label for="salaryTo">To:</label>
                            <select
                                class="p-2 block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:max-w-xs sm:text-sm sm:leading-6"
                                name="salaryTo" id="salaryTo" aria-label="Select a salary to ">
                                <option value="0" selected="">$ Any</option>
                                <option value="1000">Up to $1000</option>
                                <option value="1500">$1500</option>
                                <option value="2000">$2000</option>
                                <option value="2500">$2500</option>
                                <option value="3000">$3000</option>
                                <option value="5000">$5000</option>
                                <option value="6000">$6000</option>
                                <option value="8000">$8000</option>
                                <option value="100000">$100000+</option>
                            </select>
                        </div>
                        <div></div>
                    </div>
                </div>
                <hr>
                <div class="job_type mt-4 mb-4">
                    <div class="header">
                        <h4 class="h4 mb-3">
                            Job type
                        </h4>
                    </div>
                    <div class="label_options">
                        <label for="permanent">
                            <input class="form_check_input" id="permanent" name="permanent" type="checkbox"
                                value="Permanent">
                            <a href="#">
                                Permanent
                                <span class="number of options"></span>
                            </a>
                        </label>
                        <label for="temporary">
                            <input class="form_check_input" id="temporary" name="temporary" type="checkbox"
                                value="temporary">
                            <a href="#">
                                Temporary
                                <span class="number of options"></span>
                            </a>
                        </label>
                        <label for="contract">
                            <input class="form_check_input" id="contract" name="contract" type="checkbox"
                                value="contract">
                            <a href="#">
                                Contract
                                <span class="number of options"></span>
                            </a>
                        </label>
                        <label for="full_time">
                            <input class="form_check_input" id="full_time" name="full_time" type="checkbox"
                                value="full_time">
                            <a href="#">
                                Full-time
                                <span class="number of options"></span>
                            </a>
                        </label>
                        <label class="mb-3" for="part_time">
                            <input class="form_check_input" id="part_time" name="part_time" type="checkbox"
                                value="part_time">
                            <a href="#">
                                Part-time
                                <span class="number of options"></span>
                            </a>
                        </label>
                        <hr>
                        <label class="mt-3" for="home_work">
                            <input class="form_check_input" id="home_work" name="home_work" type="checkbox"
                                value="home_work">
                            <a href="#">
                                Work from home
                                <span class="number of options"></span>
                            </a>
                        </label>
                    </div>
                </div>
                <hr>
                <div class="posted_by mt-4 mb-4">
                    <div class="header">
                        <h4 class="h4 mb-3">
                            Posted by
                        </h4>
                    </div>
                    <div class="label_options">
                        <label for="agency">
                            <input class="form_check_input" id="agency" name="agency" type="checkbox" value="agency">
                            <a href="#">
                                Agency
                                <span class="number of options"></span>
                            </a>
                        </label>
                        <label for="employer">
                            <input class="form_check_input" id="employer" name="employer" type="checkbox"
                                value="employer">
                            <a href="#">
                                Employer
                                <span class="number of options"></span>
                            </a>
                        </label>
                    </div>
                </div>
                <hr>
                <div class="number_applicants mt-4 mb-4">
                    <div class="header">
                        <h4 class="h4">
                            Number of applicants
                        </h4>
                    </div>
                    <div class="range">
                        <div class="field">
                            <div class="value left">0</div>
                            <input type="range" min="0" max="200" value="100" steps="1" id="slider">
                            <div class="value right">200</div>
                            <div class="ml-10 text-xl" id="counter">100</div>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="dont_show mt-4 mb-4">
                    <div class="header">
                        <h4 class="h4 mb-3">
                            Don't show
                        </h4>
                    </div>
                    <div class="label_options">
                        <label for="jobs_noSalary">
                            <input class="form_check_input" id="jobs_noSalary" name="jobs_noSalary" type="checkbox"
                                value="Jobs without salary">
                            <a href="#">
                                Jobs without salary
                                <span class="number of options"></span>
                            </a>
                        </label>
                        <label for="training_courses">
                            <input class="form_check_input" id="training_courses" name="training_courses"
                                type="checkbox" value="Training courses">
                            <a href="#">
                                Training courses
                                <span class="number of options"></span>
                            </a>
                        </label>
                    </div>
                </div>
                <hr>
                <div class="date mt-4 mb-4">
                    <div class="header">
                        <h4 class="h4">Date posted</h4>
                    </div>
                    <div>
                        <div>
                            <select
                                class="p-2 block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:max-w-xs sm:text-sm sm:leading-6"
                                name="dateForm" id="dateForm" aria-label="Select a posting date ">
                                <option value="today" selected="">Today</option>
                                <option value="3days">Three days ago</option>
                                <option value="week">A week ago</option>
                                <option value="month">A month ago</option>
                            </select>
                        </div>
                        <div></div>
                    </div>
                </div>
                <hr>
                <div class="specialisms mt-4 mb-4">
                    <div class="header">
                        <h4 class="h4 mb-3">
                            Job type
                        </h4>
                    </div>
                    <div class="label_options">
                        <label for="IT">
                            <input class="form_check_input" id="IT" name="IT" type="checkbox" value="IT & Telecoms">
                            <a href="#">
                                It & Telecoms
                                <span class="number of options"></span>
                            </a>
                        </label>
                        <label for="construcation">
                            <input class="form_check_input" id="construcation" name="construcation" type="checkbox"
                                value="Construcation & Property">
                            <a href="#">
                                Construcation & Property
                                <span class="number of options"></span>
                            </a>
                        </label>
                        <label for="engineering">
                            <input class="form_check_input" id="engineering" name="engineering" type="checkbox"
                                value="Engineering">
                            <a href="#">
                                Engineering
                                <span class="number of options"></span>
                            </a>
                        </label>
                        <label for="legal">
                            <input class="form_check_input" id="legal" name="legal" type="checkbox" value="Legal">
                            <a href="#">
                                Legal
                                <span class="number of options"></span>
                            </a>
                        </label>
                        <label for="sales">
                            <input class="form_check_input" id="sales" name="sales" type="checkbox" value="Sales">
                            <a href="#">
                                Sales
                                <span class="number of options"></span>
                            </a>
                        </label>
                        <label for="banking">
                            <input class="form_check_input" id="banking" name="banking" type="checkbox" value="Banking">
                            <a href="#">
                                Banking
                                <span class="number of options"></span>
                            </a>
                        </label>
                    </div>
                </div>
                <hr>
                <div class="experience mt-4 mb-4">
                    <div class="header">
                        <h4 class="h4 mb-3">
                            Experience level
                        </h4>
                    </div>
                    <div class="label_options">
                        <label for="none">
                            <input class="form_check_input" id="none" name="none" type="checkbox" value="None">
                            <a href="#">
                                None
                                <span class="number of options"></span>
                            </a>
                        </label>
                        <label for="bachelor">
                            <input class="form_check_input" id="bachelor" name="bachelor" type="checkbox"
                                value="Bachelor">
                            <a href="#">
                                Bachelor
                                <span class="number of options"></span>
                            </a>
                        </label>
                        <label for="graduate">
                            <input class="form_check_input" id="graduate" name="graduate" type="checkbox"
                                value="Graduate">
                            <a href="#">
                                Graduate
                                <span class="number of options"></span>
                            </a>
                        </label>
                    </div>
                </div>

            </div>


            <script src="script.js"></script>

        </aside>
        <main id="post_list" class="posts container-xxl py-5">
            <div class="container">
                <h1 class="text-center mb-5 wow fadeInUp" data-wow-delay="0.1s">Job Listing</h1>
                <div class="tab-class text-center wow fadeInUp" data-wow-delay="0.3s">
                    <div class="tab-content">
                        <div class="tab-pane fade show p-0 active">
                            <?php foreach ($jobs as $job): ?>
                                <div class="job-item p-4 mb-4">
                                    <div class="row g-4">
                                        <div class="col-sm-12 col-md-8 d-flex align-items-center">
                                            <!-- Display job details -->
                                            <img class="flex-shrink-0 img-fluid border rounded" src="img/com-logo-1.jpg"
                                                alt="" style="width: 80px; height: 80px;">
                                            <div class="text-start ps-4">
                                                <h5 class="mb-3">
                                                    <?php echo $job->getTitle(); ?>
                                                </h5>
                                                <span class="text-truncate me-3"><i
                                                        class="fa fa-map-marker-alt text-primary me-2"></i>
                                                    <?php echo $job->getLocation(); ?>
                                                </span>
                                                <span class="text-truncate me-3"><i
                                                        class="far fa-clock text-primary me-2"></i>
                                                    <?php echo $job->getJobType(); ?>
                                                </span>
                                                <span class="text-truncate me-0"><i
                                                        class="far fa-money-bill-alt text-primary me-2"></i>
                                                    <?php echo $job->getSalary(); ?>
                                                </span>
                                            </div>
                                        </div>
                                        <div
                                            class="col-sm-12 col-md-4 d-flex flex-column align-items-start align-items-md-end justify-content-center">
                                            <div class="d-flex mb-3">
                                                <a class="btn btn-light btn-square me-3" href=""><i
                                                        class="far fa-heart text-primary"></i></a>
                                                <a class="btn btn-primary"
                                                    href="job_details.php?job_id=<?php echo $job->getId(); ?>">Apply Now</a>
                                            </div>
                                            <small class="text-truncate"><i
                                                    class="far fa-calendar-alt text-primary me-2"></i>Date Line:
                                                <?php echo $job->getPositionDate(); ?>
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>


                    </div>
                </div>
            </div>
            <div class="page-counter">
                Page
                <?php echo $page; ?> of
                <?php echo $totalPages; ?>
            </div>
        </main>
    </div>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>