<?php

require '../vendor/autoload.php';

try {
    $dotenv = new \Dotenv\Dotenv(__DIR__ . '/../');
    $dotenv->load();
} catch (\Dotenv\Exception\InvalidPathException $e) {
    echo ".env file was not found. Are you sure you have it?";
}

$dbConfig = include '../config/database.php';

$mysql = new \App\Database\Mysql( $dbConfig['host'], $dbConfig['database'], $dbConfig['user'], $dbConfig['password']);

$app = new App\App($mysql->getConnection());

$app->run();