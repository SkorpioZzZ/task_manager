<?php

session_start();
require_once __DIR__ . '/../src/Database.php';

// Connexion a la base de données
$database = new Database();
$pdo = $database->getConnection();

$idTask = $_GET['id'];
$idUser = $_SESSION['user_id'];

// Selection de la tache dans la BDD
$sqlQuery = "SELECT * FROM tasks WHERE user_id = :user_id AND id = :id";

$readTask = $pdo->prepare($sqlQuery);

$readTask->execute([
    'user_id' => $idUser,
    'id' => $idTask,
]);

$tasks = $readTask->fetch();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $sqlQuery = "DELETE FROM tasks WHERE user_id = :user_id AND id = :id";

    $deleteTask = $pdo->prepare($sqlQuery);

    $deleteTask->execute([
        'user_id' => $idUser,
        'id' => $idTask,
    ]);

    header('Location: liste_tache.php');
    exit;
};
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../css/style.css" rel="stylesheet">
    <title>Supprimer tache</title>
</head>

<body>
    <?php require_once __DIR__ . '/../includes/header.php'; ?>
    <main>
        <h1>Supprimer une tache</h1>
        <div class="form-container">

            <!--Formulaire de suppression de tache-->
            <form method="POST" action="">
                <h2>Voulez vous supprimer la tache ?</h2>

                <!--Affichage du des informations dans le formulaire-->
                <h3><?php echo $tasks['title'] ?></h3>

                <p><?php echo $tasks['description'] ?></p>

                <time><?php echo $tasks['due_date'] ?></time>


                <p><?php echo $tasks['status'] ?></p>

                <button type="submit">Supprimer</button>
            </form>
        </div>
    </main>
</body>

</html>