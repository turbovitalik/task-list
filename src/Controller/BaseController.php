<?php

namespace App\Controller;

use App\App;
use App\Core\Response;

class BaseController
{
    protected function resourceForbidden()
    {
        $response = new Response();
        $response->setContent('Forbidden');

        //todo: forbidden status is better
        $response->setStatus(Response::HTTP_BAD_REQUEST);

        return $response;
    }

    protected function isAdmin()
    {
        $app = App::getInstance();

        $isAdmin = $app->getAuth()->isAuthenticated();

        var_dump($isAdmin);

        return $isAdmin;
    }
}