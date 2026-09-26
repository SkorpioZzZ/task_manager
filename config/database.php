<?php

require_once __DIR__ . '/env.php';

loadEnv(__DIR__ . '/../.env');

$host = $_ENV['DB_HOST'];
$dbname = $_ENV['DB_NAME'];
$username = $_ENV['DB_USER'];
$password = $_ENV['DB_PASSWORD'];