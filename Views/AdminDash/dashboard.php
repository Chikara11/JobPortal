<?php
require_once "../../config.php";
require_once "../../Controllers/userC.php";
// Check if the userId is set in the POST data

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Back-office - Gestion des Utilisateurs</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 960px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 5px;
        }

        table,
        th,
        td {
            border: 1px solid #003366;
        }

        th,
        td {
            text-align: left;
            padding: 8px;
        }

        th {
            background-color: #003366;
            color: #fff;
        }

        .actions {
            text-align: right;
        }

        button {
            padding: 5px 10px;
            margin-left: 5px;
            cursor: pointer;
            background-color: #009933;
            /* Green */
            color: #fff;
            border: none;
            border-radius: 3px;
        }

        .dark-blue-button {
            background-color: #009933;
            /* Blue */
            color: #fff;
            /* White text */
            text-decoration: none;
            /* Remove underline */
            font-size: 14px;
            /* Smaller text size */
            padding: 3px 8px;
            /* Adjust padding */
        }
    </style>
</head>

<body>
    <div class="container">

        <h1>Gestion des Utilisateurs</h1>

        <a href="adduser.php" class="dark-blue-button">Add User</a>

        <table>
            <tr>
                <th>Nom complet</th>
                <th>Email</th>
                <th>Actions</th>
            </tr>
            <?php


            $postController = new userC();
            try {
                $results = $postController->getusers();
            } catch (Exception $e) {
                // Handle the exception (e.g., log it, display an error message)
                echo "Error fetching users: " . $e->getMessage();
                exit;
            }
            ?>
            <?php foreach ($results as $user): ?>
                <tr>
                    <td><?= $user->getFullname() ?></td>
                    <td><?= $user->getEmail() ?></td>
                    <td class="actions">
                        <a href="modifyuser.php?email=<?= $user->getEmail() ?>" class="dark-blue-button">Modifier</a>
                        <form style="display:inline-block;" action="deleteuser.php" method="POST"
                            onsubmit="return confirm('Are you sure you want to delete this user?');">
                            <input type="hidden" name="email" value="<?= $user->getEmail() ?>">
                            <button type="submit">Delete User</button>
                        </form>



                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
</body>

</html>