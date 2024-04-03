<?php

require_once "../../config.php";
require_once "../../Models/job.php";
require_once "../../vendor/autoload.php";

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();


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
            $job_query .= " AND location = :location";
            $params[':location'] = $location;
        }

        if ($type) {
            $job_query .= " AND job_type = :type";
            $params[':type'] = $type;
        }

        if ($salary) {
            $job_query .= " AND salary >= :salary";
            $params[':salary'] = $salary;
        }

        $job_query .= " LIMIT :offset, :limit";
        $params[':offset'] = (int) $offset;
        $params[':limit'] = (int) $limit;

        $job_query_run = $this->pdo->prepare($job_query);

        // Bind parameters
        foreach ($params as $param => $value) {
            $job_query_run->bindValue($param, $value);
        }

        // Execute prepared statement
        $job_query_run->execute();

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



}