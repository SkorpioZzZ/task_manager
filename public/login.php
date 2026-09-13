<?php
session_start();
require_once __DIR__ . '/../src/Database.php';

// Récupére les données envoyées par le formulaire
$postData = $_POST;

// Formulaire de connexion

// SI email ET mot de passe existent ALORS
if (isset($postData['email']) && isset($postData['password'])) {

    // SI l'email n'est pas valide ALORS
    if (!filter_var($postData['email'], FILTER_VALIDATE_EMAIL)) {

        // Créer un message d'erreur
        $errorMessage = 'Email ou mot de passe invalide';
    } else {

        $database = new Database();
        $pdo = $database->getConnection();

        // Recherche dans la table USERS
        $sql = "SELECT * FROM users WHERE email = :email";

        $query = $pdo->prepare($sql);

        $query->execute([
            'email' => $postData['email'],
        ]);

        $users = $query->fetch();

        // SI mot de passe correspond à la BDD
        if (password_verify($postData['password'], $users['password'])) {
            // On stocke la session dans une variable
            $_SESSION['user_id'] = $users['id'];
            header('Location: liste_tache.php');
            exit;
        } else {
            $errorMessage = 'Email ou mot de passe invalide';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="/projet/task-manager/css/style.css" rel="stylesheet">
    <title>Connexion</title>
</head>

<body>
    <?php require_once __DIR__ . '/../includes/header.php'; ?>

    <?php
    if (isset($errorMessage)) {
        echo $errorMessage;
    }
    ?>

    <form method="POST">

        <div class="form-group">
            <div class="form-label">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email" aria-decridedby="email-help" placeholder="you@exemple.com">
            </div>
            <div class="form-label">
                <label for="password">Mot de Passe</label>
                <input type="password" class="form-control" id="password" name="password">
            </div>


            <button type="submit" class="btn btn-primary">Connexion</button>

            <p>
                Pas encore de compte ?
                <a href="register.php">Créer un compte</a>
            </p>
        </div>
    </form>
</body>

</html>