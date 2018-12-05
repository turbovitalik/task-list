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

        $this->redirect('/task/list');
    }

    public function check()
    {
        $data = $this->request->getPost();

        $app = App::getInstance();
        $app->getAuth()->login($data);

        $this->redirect('/task/list');
    }
}