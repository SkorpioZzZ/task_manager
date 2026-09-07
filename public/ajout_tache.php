<?php

require_once __DIR__ . '/../src/Database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title_tache = $_POST['title'];
    $descriptionTache = $_POST['description'];
    $dateFinTache = $_POST['date'];

    if ($title_tache == "" || $descriptionTache == "" || $dateFinTache == "") {
        echo ("Il manque des information");
    } else {
        $database = new Database();
        $pdo = $database->getConnection();

        $sqlQuery = "INSERT INTO tasks(title, description, status, due_date) VALUES (:title, :description, 'todo', :date)";

        $insertTask = $pdo->prepare($sqlQuery);

        $insertTask->execute([
            'title' => $title_tache,
            'description' => $descriptionTache,
            'date' => $dateFinTache,
        ]);
        echo "Formulaire bien reçu !";
    };
}

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter une tache</title>
</head>

<body>
    <h1>Ajouter une tache</h1>

    <!--Formulaire d'ajout de tache-->
    <form method="POST" action="">
        <label for="name">Titre de la tache</label>
        <input type="text" name="title" required></br></br>
        <label for="description">Description de la tache</label>
        <input type="text" name="description" required></br></br>
        <label>Date d'échéance</label>
        <input type="date" name="date" required></br></br>
        <input type="submit" name="submit">
    </form>
</body>

</html>