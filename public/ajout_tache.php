<?php
session_start();
require_once __DIR__ . '/../src/Database.php';
require_once __DIR__ . '/../includes/header.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title_tache = $_POST['title'];
    $descriptionTache = $_POST['description'];
    $dateFinTache = $_POST['date'];
    $users = $_SESSION['user_id'];

    if ($title_tache == "" || $descriptionTache == "" || $dateFinTache == "") {
        echo ("Il manque des information");
    } else {
        $database = new Database();
        $pdo = $database->getConnection();

        $sqlQuery = "INSERT INTO tasks (user_id, title, description, status, due_date) VALUES (:user_id, :title, :description, 'todo', :date)";

        $insertTask = $pdo->prepare($sqlQuery);

        $insertTask->execute([
            'user_id' => $users,
            'title' => $title_tache,
            'description' => $descriptionTache,
            'date' => $dateFinTache,
        ]);
        header('Location: ajout_tache.php');
        exit;
    };
}

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../css/style.css" rel="stylesheet">
    <title>Nouvelle Tâche</title>
</head>

<body>
    <main>
        <h1>Ajouter une tache</h1>
        <div class="form-container">
            <!--Formulaire d'ajout de tache-->
            <form method="POST" action="">
                <label for="name">Titre de la tache</label>
                <input type="text" name="title" id="name" required>

                <label for="description">Description de la tache</label>
                <textarea name="description" id="description" required></textarea>

                <label for="date">Date d'échéance</label>
                <input type="date" name="date" id="date" required>

                <input type="submit" name="submit">
            </form>
        </div>
    </main>
</body>

</html>