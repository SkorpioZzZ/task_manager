<?php

function loadEnv(string $path): void
{
    if (!file_exists($path)) {
        throw new RuntimeException("Fichier .env introuvable : $path");
    }

    $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

    foreach ($lines as $line) {
        // Ignore les commentaires
        if (str_starts_with(trim($line), '#')) {
            continue;
        }

        [$name, $value] = explode('=', $line, 2);
        $name = trim($name);
        $value = trim($value);

        // Retire les guillemets si présents
        $value = trim($value, '"\'');

        $_ENV[$name] = $value;
        putenv("$name=$value");
    }
}