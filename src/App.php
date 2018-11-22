<?php

namespace App;

use App\Controller\TaskController;
use App\Core\Request;
use App\Core\Response;
use PDO;

class App
{
    /**
     * @var PDO
     */
    protected $db;

    /**
     * App constructor.
     * @param PDO $db
     */
    public function __construct(PDO $db)
    {
        $this->db = $db;
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


        $controller = new TaskController($request);

        $method = 'index';

        $response = $controller->{$method}();

        return $response;
    }
}