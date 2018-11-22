<?php

require '../vendor/autoload.php';

define('APP_ROOT', __DIR__ . '/../');

try {
    $dotenv = new \Dotenv\Dotenv(__DIR__ . '/../');
    $dotenv->load();
} catch (\Dotenv\Exception\InvalidPathException $e) {
    echo ".env file was not found. Are you sure you have it?";
}

// Setup database
$dbConfig = include '../config/database.php';
$mysql = new \App\Database\Mysql( $dbConfig['host'], $dbConfig['database'], $dbConfig['user'], $dbConfig['password']);

// Setup routing
$router = new \App\Core\Router();
$router->addRoute('task/list', \App\Controller\TaskController::class . '::index');
$router->addRoute('task/create', \App\Controller\TaskController::class . '::create');
$router->addRoute('task/store', \App\Controller\TaskController::class . '::store');

// Init application object
$app = new App\App($mysql->getConnection(), $router);

// Run
$app->run();