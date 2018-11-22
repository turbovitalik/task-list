<?php

namespace App;

use App\Core\Auth;
use App\Core\Request;
use App\Core\Response;
use App\Core\Router;
use PDO;

class App
{
    /**
     * @var PDO
     */
    protected $db;

    /**
     * @var Router
     */
    protected $router;

    /**
     * @var Auth
     */
    protected $auth;

    /**
     * @var App
     */
    private static $instance;

    /**
     * App constructor.
     * @param PDO $db
     */
    public function __construct(PDO $db, Router $router, Auth $auth)
    {
        $this->db = $db;
        $this->router = $router;
        $this->auth = $auth;

        self::$instance = $this;

    }

    public function run()
    {
        $request = Request::createFromGlobals();

        $response = $this->handleRequest($request);

        $response->send();
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function handleRequest(Request $request): Response
    {
        $response = $this->router->dispatch($request);

        return $response;
    }

    /**
     * @return App
     */
    public static function getInstance()
    {
        return self::$instance;
    }

    /**
     * @return Auth
     */
    public function getAuth()
    {
        return $this->auth;
    }

    /**
     * @return PDO
     */
    public function getDb()
    {
        return $this->db;
    }
}