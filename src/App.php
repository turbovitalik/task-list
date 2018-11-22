<?php

namespace App;

use App\Controller\TaskController;
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
     * App constructor.
     * @param PDO $db
     */
    public function __construct(PDO $db, Router $router)
    {
        $this->db = $db;
        $this->router = $router;
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
}