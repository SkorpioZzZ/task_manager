<?php

require_once __DIR__ . '/../src/Database.php';

// Création de l'objet
$database = new Database();

// Connexion dans $pdo pour faire des requetes SQL
$pdo = $database->getConnection();

echo "Connextion réussie !";
