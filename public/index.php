<?php
session_start();
require_once __DIR__ . '/../src/Database.php';
require_once __DIR__ . '/../includes/header.php';


// Création de l'objet
$database = new Database();

// Connexion dans $pdo pour faire des requetes SQL
$pdo = $database->getConnection();

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestionnaire de tache</title>
</head>

<body>
    <h1>Gestionnaire de taches</h1>

</body>

</html>