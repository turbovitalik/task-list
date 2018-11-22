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

// Setup session
$sessionFactory = new \Aura\Session\SessionFactory();
$session = $sessionFactory->newInstance($_COOKIE);
$segment = $session->getSegment('user');

// Setup authenticator
$auth = new \App\Core\Auth($segment);

// Setup routing
$router = new \App\Core\Router();
$router->addRoute('task/list', \App\Controller\TaskController::class . '::index');
$router->addRoute('task/create', \App\Controller\TaskController::class . '::create');
$router->addRoute('task/store', \App\Controller\TaskController::class . '::store');
$router->addRoute('task/edit', \App\Controller\TaskController::class . '::edit');
$router->addRoute('login', \App\Controller\LoginController::class . '::index');
$router->addRoute('logout', \App\Controller\LoginController::class . '::logout');
$router->addRoute('login/check', \App\Controller\LoginController::class . '::check');

// Init application object
$app = new App\App($mysql->getConnection(), $router, $auth);

// Run
$app->run();