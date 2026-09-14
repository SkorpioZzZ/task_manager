<?php

require_once __DIR__ . '/../src/Database.php';
session_start();

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
    $title_tache = $_POST['title'];
    $descriptionTache = $_POST['description'];
    $dateFinTache = $_POST['date'];
    $users = $_SESSION['user_id'];
    $status = $_POST['status'];

    if ($title_tache == "" || $descriptionTache == "" || $dateFinTache == "" || $status == "") {
        echo ("Il manque des information");
    } else {
        $sqlQuery = "UPDATE tasks
            SET title = :title, description = :description, status = :status, due_date = :due_date
            WHERE user_id = :user_id AND id = :id";

        $updateTask = $pdo->prepare($sqlQuery);

        $updateTask->execute([
            'title' => $_POST['title'],
            'description' => $_POST['description'],
            'status' => $_POST['status'],
            'due_date' => $dateFinTache,
            'user_id' => $idUser,
            'id' => $idTask,
        ]);

        header('Location: liste_tache.php');
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
    <title>Modifier tache</title>
</head>

<body>
    <?php require_once __DIR__ . '/../includes/header.php'; ?>
    <main>
        <h1>Modifier une tache</h1>
        <div class="form-container">

            <!--Formulaire de modification de tache-->
            <form method="POST" action="">

                <!--Affichage du des informations dans le formulaire-->
                <label for="name">Titre de la tache</label>
                <input type="text" name="title" id="name" value="<?php echo $tasks['title'] ?>">

                <label for="description">Description de la tache</label>
                <textarea name="description" id="description"><?php echo $tasks['description'] ?></textarea>

                <label for="date">Date d'échéance</label>
                <input type="date" name="date" id="date" value="<?php echo $tasks['due_date'] ?>">

                <label for="status">État de la tache</label>
                <input type="text" name="status" id="status" value="<?php echo $tasks['status'] ?>">

                <input type="submit" name="submit">
            </form>
        </div>
    </main>
</body>

</html>