<?php

namespace App\Controller;

use App\Core\Request;
use App\Core\View;

class LoginController
{
    // TODO: Duplication. Use parent class
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function index()
    {
        $view = new View();

        return $view->render('auth/login', []);
    }
}