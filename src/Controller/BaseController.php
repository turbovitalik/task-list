<?php

namespace App\Controller;

use App\App;
use App\Core\Request;
use App\Core\Response;
use App\Core\View;

class BaseController
{
    protected $view;

    protected $request;

    public function __construct(Request $request, View $view)
    {
        $this->view = $view;
        $this->request = $request;
    }

    protected function resourceForbidden()
    {
        $response = new Response();
        $response->setContent('Forbidden');

        //todo: forbidden status is better
        $response->setStatus(Response::HTTP_BAD_REQUEST);

        return $response;
    }

    protected function resourceNotFound()
    {
        $response = new Response();
        $response->setContent('Not found');
        $response->setStatus(Response::HTTP_NOT_FOUND);

        return $response;
    }

    protected function isAdmin()
    {
        $app = App::getInstance();

        $isAdmin = $app->getAuth()->isAuthenticated();

        return $isAdmin;
    }
}