<?php
session_start();
require_once __DIR__ . '/../src/Database.php';

$user_id = $_SESSION['user_id'];

$database = new Database();
$pdo = $database->getConnection();

$sql = "SELECT id, user_id, title, description, status, due_date
        FROM tasks
        WHERE user_id = :user_id";

$request = $pdo->prepare($sql);

$request->execute([
    'user_id' => $user_id
]);

$tasks = $request->fetchAll();
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
            <div class="liste_task">
                <h2 class="title_task"><?php echo $task['title']; ?></h2>
                <p class="description"><?php echo $task['description']; ?></p>
                <p class="status"><?php echo $task['status']; ?></p>
                <p class="due_date"><?php echo $task['due_date']; ?></p>
                <a href="modify_task.php?id=<?php echo ($task['id']) ?>">Modifier</a>
                <a href="delete_task.php?id=<?php echo ($task['id']) ?>">Supprimer</a>
            </div>
        <?php } ?>

    </main>

</body>

</html>