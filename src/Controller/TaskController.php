<?php

namespace App\Controller;

use App\Core\Response;
use App\Core\View;

class TaskController
{
    public function index()
    {
//        $taskService = new TaskService();
//
//        $tasks = $taskService->getTaskList();



        $view = new View();

        return $view->render('task/list');
    }

}