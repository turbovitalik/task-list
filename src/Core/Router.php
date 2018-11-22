<?php

namespace App\Core;

use App\Controller\TaskController;

class Router
{
    /**
     * @var array
     */
    protected $routeMap;

    /**
     * @param Request $request
     * @return Response
     */
    public function dispatch(Request $request): Response
    {
        $resolvedParts = $this->resolveController($request->getRoutePath());

        $controllerName = $resolvedParts[0];
        $action = $resolvedParts[1];

        $controller = new $controllerName($request);
        $response = $controller->{$action}();

        return $response;
    }

    /**
     * @param array $map
     */
    public function setRouteMap(array $map)
    {
        $this->routeMap = $map;
    }

    public function resolveController(string $path)
    {

        $routeMap = [
            'task/list' => 'App\Controller\TaskController::index',
            'task/create' => 'App\Controller\TaskController::create',
            'task/store' => 'App\Controller\TaskController::store',
        ];

        $match = array_key_exists($path, $routeMap) ? $routeMap[$path] : false;

        if (!$match) {
            //todo: Maybe, throw NotFoundException
            throw new \Exception("Route '$path' is not defined");
        }


        $parts = explode('::', $match);

        return [$parts[0], $parts[1]];

    }

    public function addRoute()
    {
        //todo: some validation logic
    }

}