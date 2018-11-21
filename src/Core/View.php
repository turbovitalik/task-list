<?php

namespace App\Core;

class View
{
    /**
     * @param string $view
     * @param array $params
     * @return Response
     * @throws \Exception
     */
    public function render(string $view, array $params = []): Response
    {
        $viewFile = $this->resolvePathToView($view);

        if (!file_exists($viewFile)) {
            throw new \Exception("View file not found ('$view') in 'views' folder");
        }

        extract($params);

        ob_start();
        include($viewFile);
        $content = ob_get_contents();
        ob_end_clean();


        $response = new Response();
        $response->setContent($content);
        $response->setStatus(Response::HTTP_OK);

        return $response;
    }

    /**
     * @param string $viewName
     * @return string
     */
    public function resolvePathToView(string $viewName): string
    {
        $path = APP_ROOT . 'views/' . $viewName . '.php';

        return $path;
    }
}