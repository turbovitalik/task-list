<?php

namespace App\Core;

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

    /**
     * @param string $path
     * @return array
     * @throws \Exception
     */
    public function resolveController(string $path)
    {
        $routeMap = $this->routeMap;

        $match = array_key_exists($path, $routeMap) ? $routeMap[$path] : false;

        if (!$match) {
            //todo: Maybe, throw NotFoundException
            throw new \Exception("Route '$path' is not defined");
        }

        $parts = explode('::', $match);

        return [$parts[0], $parts[1]];
    }

    /**
     * @param $path
     * @param $action
     */
    public function addRoute($path, $action)
    {
        // todo: add some validation
        $this->routeMap[$path] = $action;
    }

}