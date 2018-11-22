<?php

namespace App\Controller;

use App\App;

class LoginController extends BaseController
{
    public function index()
    {
        return $this->view->render('auth/login', []);
    }

    public function logout()
    {
        $app = App::getInstance();
        $app->getAuth()->logout();

        //todo: not good, implement redirect() method later
        header('Location: /task/list');
    }

    public function check()
    {
        $data = ['username' => 'admin', 'password' => '111'];

        $app = App::getInstance();
        $app->getAuth()->login($data);

        //todo: not good, implement redirect() method later
        header('Location: /task/list');
    }
}