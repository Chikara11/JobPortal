<?php

require_once "../../config.php";
require_once "../../Models/job.php";



class JobC
{

    private $pdo;

    public function __construct()
    {
        $this->pdo = config::getConnexion();
    }

    public function getJobs($offset, $limit, $location = null, $type = null, $salary = null)
    {



        $jobs = array();

        $job_query = "SELECT * FROM job_posts WHERE 1";
        $params = array();

        if ($location) {
            $job_query .= " AND location = ?";
            $params[] = $location;
        }

        if ($type) {
            $job_query .= " AND job_type = ?";
            $params[] = $type;
        }

        if ($salary) {
            $job_query .= " AND salary >= ?";
            $params[] = $salary;
        }



        $job_query_run = $this->pdo->prepare($job_query);

        // Execute prepared statement
        $job_query_run->execute($params);

        // Fetch one row at a time
        while ($row = $job_query_run->fetch(PDO::FETCH_ASSOC)) {
            // Create Job objects and add them to the array
            $job = new Job(
                $row['company_name'],
                $row['title'],
                $row['function'],
                $row['location'],
                $row['seniority_lvl'],
                $row['description'],
                $row['job_type'],
                $row['industry'],
                $row['experience'],
                $row['degree'],
                $row['salary'],
            );

            // Add the job object to the array
            $jobs[] = $job;
        }

        return $jobs;
    }

    public function getTotalJobs($location = null, $type = null, $salary = null)
    {
        $sql = "SELECT COUNT(*) AS total_jobs FROM job_posts WHERE 1";
        $params = array();

        if ($location) {
            $sql .= " AND location = :location";
            $params[':location'] = $location;
        }

        if ($type) {
            $sql .= " AND job_type = :type";
            $params[':type'] = $type;
        }

        if ($salary) {
            $sql .= " AND salary >= :salary";
            $params[':salary'] = $salary;
        }

        $result = $this->pdo->prepare($sql);

        // Bind parameters
        foreach ($params as $param => $value) {
            $result->bindValue($param, $value);
        }

        // Execute prepared statement
        $result->execute();

        // Check if query was successful
        if ($result) {
            $row = $result->fetch(PDO::FETCH_ASSOC);
            return $row['total_jobs'];
        } else {
            return 0;
        }
    }

    public function add_post()
    {
        try {
            if (isset($_POST["add_post"])) {
                $companyName = $_POST["CompanyName"];
                $jobTitle = $_POST["jobTitle"];
                $JobType = $_POST["jobType"];
                $location = $_POST["location"];
                $experience = $_POST["experience"];
                $industry = $_POST["industry"];
                $job_function = $_POST["job_function"];
                $degree = $_POST["degree"];
                $description = $_POST["description"];
                $seniorityLevel = $_POST["seniority"];
                $salary = $_POST["salary"];

                // Create a new Job instance based on user type
                $newJob = new Job(
                    $companyName,
                    $jobTitle,
                    $job_function,
                    $location,
                    $seniorityLevel,
                    $description,
                    $JobType,
                    $industry,
                    $experience,
                    $degree,
                    $salary
                );

                $pdo = config::getConnexion();
                $sql = "INSERT INTO job_posts (company_name, title, function, location, seniority_lvl, description,job_type,industry,experience,degree,salary) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([
                    $companyName,
                    $jobTitle,
                    $job_function,
                    $location,
                    $seniorityLevel,
                    $description,
                    $JobType,
                    $industry,
                    $experience,
                    $degree,
                    $salary
                ]);
                header("Location: ../../Views/Profile/profilee.php");
                exit();
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }

}