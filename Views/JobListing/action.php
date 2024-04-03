<?php
require_once "../../config.php";

if (isset($_POST['action'])) {
    if ($_POST['action'] == 'fetchData') {
        $query = "SELECT * FROM job_posts WHERE 1";

        // Add conditions based on filters
        if (isset($_POST['salaryFrom']) && $_POST['salaryFrom'] != '') {
            $salaryFrom = $_POST['salaryFrom'];
            $query .= " AND salary >= :salaryFrom";
        }
        if (isset($_POST['salaryTo']) && $_POST['salaryTo'] != '') {
            $salaryTo = $_POST['salaryTo'];
            $query .= " AND salary <= :salaryTo";
        }
        if (isset($_POST['permanent']) && $_POST['permanent'] == 'true') {
            $query .= " AND job_type = 'Permanent'";
        }
        // Add other conditions based on other filters similarly

        $query .= " ORDER BY job_posts.id DESC";

        getData($query);
    }
}

function getData($query)
{
    try {
        $pdo = config::getConnexion();
        $statement = $pdo->prepare($query);

        // Bind parameters if necessary
        if (isset($salaryFrom)) {
            $statement->bindParam(':salaryFrom', $salaryFrom);
        }
        if (isset($salaryTo)) {
            $statement->bindParam(':salaryTo', $salaryTo);
        }

        $statement->execute();

        $output = $statement->fetchAll(PDO::FETCH_ASSOC);

        if (!empty($output)) {
            echo json_encode($output);
        } else {
            echo "No records found.";
        }
    } catch (PDOException $e) {
        die("Error: " . $e->getMessage());
    }
}
?>