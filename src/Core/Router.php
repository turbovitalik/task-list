<?php

namespace App\Core;

use App\Controller\TaskController;

class Router
{
    public function dispatch(Request $request)
    {
        $controller = new TaskController($request);

        $method = 'index';

        $response = $controller->{$method}();

        return $response;
    }
}