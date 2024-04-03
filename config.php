<?php
class config
{
    private static $pdo = NULL;

    public static function getConnexion()
    {
        if (!isset (self::$pdo)) {
            try {
                self::$pdo = new PDO(
                    'mysql:host=localhost;dbname=login2',
                    'root',
                    '',
                    [
                        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
                    ]
                );
            } catch (Exception $e) {
                die ('Erreur: ' . $e->getMessage());
            }
        }
        return self::$pdo;
    }


    public static function getPaths()
    {
        return array(
            'home' => '/login2/Views/HomePage/home.php',
            'jobs' => '/login2/Views/JobListing/jobs.php',
            // Add more paths as needed
        );
    }
}
