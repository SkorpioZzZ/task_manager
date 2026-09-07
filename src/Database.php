<?php

// Création de la classe Database pour gérer la connexion à la base de données
class Database
{
    // Propriété pour stocker l'objet PDO
    private PDO $pdo;

    // Constructeur de la base de données qui initialise la connexion à la base de données
    public function __construct()
    {
        // Inclusion du fichier de configuration de la BDD
        require __DIR__ . '/../config/database.php';

        // Création d'une nouvelle instance de PDO pour se connecter à la base de données
        $this->pdo = new PDO(

            // DSN (Data Source Name) pour la connexion à la base de données MySQL
            "mysql:host=$host;dbname=$dbname;charset=utf8mb4",

            // Nom d'utilisateur et mot de passe pour la connexion à la base de données
            $username,
            $password
        );
    }

    // Fonction pour récupérer la connexion depuis l'extérieur de la classe
    public function getConnection(): PDO
    {
        // Représente la connexion stockée dans l'objet
        return $this->pdo;
    }
}
