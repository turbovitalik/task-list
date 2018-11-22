<?php

namespace App\Controller;

use App\App;
use App\Core\Request;
use App\Core\View;

class LoginController
{
    public function index()
    {
        $view = new View();

        return $view->render('auth/login', []);
    }

    public function check()
    {
        $data = ['username' => 'admin', 'password' => '111'];

        $app = App::getInstance();
        $app->getAuth()->login($data);
    }
}