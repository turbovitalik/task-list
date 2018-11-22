<?php

namespace App\Controller;

use App\App;
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

    public function check()
    {
        $data = ['username' => 'admin', 'password' => '111'];

        $app = App::getInstance();
        $app->getAuth()->login($data);
    }
}