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
                $row['id'],
                $row['company_name'],
                $row['title'],
                $row['function'],
                $row['location'],
                $row['seniority_lvl'],
                $row['description'],
                $row['position_date'],
                $row['job_type'],
                $row['industry'],
                $row['experience'],
                $row['degree'],
                $row['salary'],
                $row['recruiter_id'],
                $row['recruiter_name'],
                $row['status']
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

    public function register($user_type)
    {
        try {
            if (isset($_POST["submit"])) {
                $fullname = $_POST["fullname"];
                $email = $_POST["email"];
                $tel = $_POST["tel"];
                $password = $_POST["password"];
                $confirm_password = $_POST["confirm_password"];

                // Create a new Job instance based on user type
                $newJob = new Job($companyName, $jobTitle, $jobFunction, $location, $verify_token, $user_type);

                // Save the new job to the database
                $this->saveJobToDatabase($newJob);

                $_SESSION['status'] = "<div class='alert alert-success'>You are registered successfully! Please verify your email address.</div>";
                header("Location: ../../Views/Auth/login.php");
                exit(); // Add exit() after header to stop further execution
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }

}