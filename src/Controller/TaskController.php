<?php

namespace App\Controller;

use App\Core\Paginator;
use App\Core\Request;
use App\Core\View;
use App\Model\Task;
use App\Repository\TaskRepository;
use App\Service\TaskService;

class TaskController extends BaseController
{
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function index()
    {
        $taskRepository = new TaskRepository();
        $taskService = new TaskService($taskRepository);

        $request = $this->request;

        $itemsPerPage = 3;

        $sortBy = $request->get('sortBy');
        $order = $request->get('order');
        $page = $request->get('page') ?? 1;

        $sort = [];
        $sort[$sortBy] = $order;

        $tasks = $taskService->getTaskList($itemsPerPage, $page, $sort);

        $paginator = new Paginator($this->request, $taskRepository);
        $paginator->setItemsPerPage($itemsPerPage);


        $view = new View();

        return $view->render('task/list', ['tasks' => $tasks, 'pagination' => $paginator->view()]);
    }

    public function create()
    {
        $view = new View();

        return $view->render('task/new', []);
    }

    public function store()
    {
        $request = $this->request;

        $postData = $request->getPost();

        $task = Task::create($postData);

        $taskRepository = new TaskRepository();

        $taskRepository->addTask($task);
    }

    public function edit()
    {
        if (!$this->isAdmin()) {
            return $this->resourceForbidden();
        }


    }

}