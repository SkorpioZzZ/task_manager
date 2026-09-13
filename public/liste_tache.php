<?php
session_start();
require_once __DIR__ . '/../src/Database.php';

$user_id = $_SESSION['user_id'];

$database = new Database();
$pdo = $database->getConnection();

$sql = "SELECT user_id, title, description, status, due_date FROM tasks WHERE user_id = :user_id";

$requete = $pdo->prepare($sql);

$requete->execute([
    'user_id' => $user_id
]);

$tasks = $requete->fetchAll();
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="/projet/task-manager/css/style.css" rel="stylesheet">
    <title>Liste tâche</title>
</head>

<body>
    <?php require_once __DIR__ . '/../includes/header.php'; ?>

    <main>
        <h1>Liste des taches</h1>

        <?php foreach ($tasks as $task) { ?>
            <div class="task">
                <h2><?php echo $task['title']; ?></h2>
                <p><?php echo $task['description']; ?></p>
                <p><?php echo $task['status']; ?></p>
                <p><?php echo $task['due_date']; ?></p>
            </div>
        <?php } ?>

    </main>

</body>

</html>