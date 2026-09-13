<?php

require_once __DIR__ . '/../src/Database.php';

// Récupére les données envoyées par le formulaire
$postData = $_POST;

// Formulaire inscription

if (!empty($_POST)) {
    // SI email, password et username sont NULL
    if ((!isset($postData['email'])) || (!isset($postData['password'])) || (!isset($postData['username']))) {
        $errorMessage = 'Il manque des informations';
    } else {

        // SI email invalide
        if (!filter_var($postData['email'], FILTER_VALIDATE_EMAIL)) {
            $errorMessage = 'Adresse mail incorrect';
        } else {

            // Connexion à la BDD
            $database = new database();
            $pdo = $database->getConnection();

            // Selectionne username et email dans la table users
            $sql = 'SELECT username, email FROM users WHERE username = :username OR email = :email';

            $query = $pdo->prepare($sql);

            $query->execute([
                'username' => $postData['username'],
                'email' => $postData['email']
            ]);

            $id_Exist = $query->fetch();

            // SI des email ou utilisateur existe
            if ($id_Exist) {
                $errorMessage = 'Utilisateur ou adresse mail deja existant';
            } else {

                // Hashage du mot de passe
                $postData['password'] = password_hash($postData['password'], PASSWORD_DEFAULT);

                $sql = 'INSERT INTO users (username, email, password) VALUES (:username, :email, :password)';

                $query = $pdo->prepare($sql);

                $query->execute([
                    'username' => $postData['username'],
                    'email' => $postData['email'],
                    'password' => $postData['password']
                ]);

                header('Location: login.php');
                exit;
            }
        }
    }
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>inscription</title>
</head>

<body>
    <?php
    if (isset($errorMessage)) {
        echo $errorMessage;
    }
    ?>
    <form method="POST">
        <label for="username" class="form-label">Nom d'utilisateur</label>
        <input type="text" class="form-control" id="username" name="username" aria-describedby="username-help" placeholder="Votre nom d'utilisateur">

        <label for="email" class="form-label">Email</label>
        <input type="email" class="form-control" id="email" name="email" aria-decridedby="email-help" placeholder="you@exemple.com">

        <label for="password" class="form-label">Mot de Passe</label>
        <input type="password" class="form-control" id="password" name="password">

        <button type="submit" class="btn btn-primary">Envoyer</button>

        <p>
            Vous avez deja un compte ?
            <a href="login.php">Se connecter</a>
        </p>
    </form>
</body>

</html>