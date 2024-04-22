<?php
require_once "../../config.php";

if (isset($_POST['action'])) {
    if ($_POST['action'] == 'fetchData') {
        $query = "SELECT * FROM job_posts WHERE 1";
        getData($query);
    }

    if ($_POST['action'] == 'searchRecord') {
        // Check if any filters are selected
        if (isset($_POST['filters'])) {
            $filters = $_POST['filters'];
            $conditions = [];

            // Handle salary range filters
            $salaryFrom = $_POST['filters']['salaryFrom'];
            $salaryTo = $_POST['filters']['salaryTo'];

            if ($salaryFrom != 0) {
                $conditions[] = "salary >= " . $salaryFrom;
            }

            if ($salaryTo != 0) {
                $conditions[] = "salary <= " . $salaryTo;
            }

            // Handle job type filters
            $selectedJobTypes = [];
            foreach ($filters as $filter => $value) {
                if ($value === 'true') {
                    switch ($filter) {
                        case 'permanent':
                        case 'temporary':
                        case 'contract':
                        case 'full_time':
                        case 'part_time':
                        case 'home_work':
                            $selectedJobTypes[] = $filter;
                            break;
                    }
                }
            }

            // Add job type condition if any job types are selected
            if (!empty($selectedJobTypes)) {
                $conditions[] = "job_type IN ('" . implode("', '", $selectedJobTypes) . "')";
            }

            // Construct the final query
            if (!empty($conditions)) {
                $query = "SELECT * FROM job_posts WHERE " . implode(" AND ", $conditions);
            } else {
                $query = "SELECT * FROM job_posts";
            }

            // Execute the query
            getData($query);
        }
    }
}

function getData($query)
{
    try {
        $output = "";

        $pdo = config::getConnexion();
        $statement = $pdo->prepare($query);

        $statement->execute();



        if ($statement->rowCount() > 0) {
            foreach ($statement as $row) {
                $output .= '
                <div class="tab-pane fade show p-0 active">
                    <div class="job-item p-4 mb-4">
                        <div class="row g-4">
                            <div class="col-sm-12 col-md-8 d-flex align-items-center">
                                <!-- Display job details -->
                                <img class="flex-shrink-0 img-fluid border rounded" src="' . $row["Picture"] . '" alt="" style="width: 80px; height: 80px;">
                                <div class="text-start ps-4">
                                    <h5 class="mb-3">' . $row['title'] . '</h5>
                                    <span class="text-truncate me-3"><i class="fa fa-map-marker-alt text-primary me-2"></i>' . $row['location'] . '</span>
                                    <span class="text-truncate me-3"><i class="far fa-clock text-primary me-2"></i>' . $row['job_type'] . '</span>
                                    <span class="text-truncate me-0"><i class="far fa-money-bill-alt text-primary me-2"></i>' . $row['salary'] . '</span>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-4 d-flex flex-column align-items-start align-items-md-end justify-content-center">
                                <div class="d-flex mb-3">
                                    <a class="btn btn-light btn-square me-3" href="#"><i class="far fa-heart text-primary"></i></a>
                                    <a class="Button btn btn-primary" href="job_details.php?id=' . $row['id'] . '">Apply Now</a>
                                </div>
                                <small class="text-truncate"><i class="far fa-calendar-alt text-primary me-2"></i>Date Line: ' . $row['position_date'] . '</small>
                            </div>
                        </div>
                    </div>
                </div>';
            }
        }


        if (!empty($output)) {
            echo $output;
        } else {
            echo $output;
            echo "No records found.";
        }
    } catch (PDOException $e) {
        die("Error: " . $e->getMessage());
    }
}
?>