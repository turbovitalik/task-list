<?php

namespace App\Controller;

use App\App;
use App\Core\Paginator;
use App\Core\Request;
use App\Core\View;
use App\Database\TaskMapper;
use App\Model\Task;
use App\Repository\TaskRepository;
use App\Service\TaskService;

class TaskController extends BaseController
{
    /**
     * @var TaskRepository
     */
    protected $taskRepository;

    public function __construct(Request $request, View $view)
    {
        parent::__construct($request, $view);

        $db = App::getInstance()->getDb();

        $mapper = new TaskMapper($db);

        $taskRepository = new TaskRepository($mapper);

        $this->taskRepository = $taskRepository;
    }

    public function index()
    {
        $taskService = new TaskService($this->taskRepository);

        $itemsPerPage = 3;

        $sortBy = $this->request->get('sortBy');
        $order = $this->request->get('order');
        $page = $this->request->get('page') ?? 1;

        $sort = [];

        if ($sortBy) {
            $order = $order ? $order : 'ASC';
            $sort[$sortBy] = $order;
        }

        $tasks = $taskService->getTaskList($itemsPerPage, $page, $sort);

        $paginator = new Paginator($this->request, $this->taskRepository);
        $paginator->setItemsPerPage($itemsPerPage);

        return $this->view->render('task/list', ['tasks' => $tasks, 'pagination' => $paginator->view(), 'isAdmin' => $this->isAdmin()]);
    }

    public function create()
    {
        return $this->view->render('task/new', []);
    }

    public function store()
    {
        $postData = $this->request->getPost();

        $taskRepository = new TaskRepository();

        if (isset($postData['id'])) {
            $taskRepository->update($postData['id'], $postData);
        } else {
            $task = Task::create($postData);
            $taskRepository->addTask($task);
        }
    }

    public function edit()
    {
        if (!$this->isAdmin()) {
            return $this->resourceForbidden();
        }

        $id = (int) $this->request->get('id');

        $task = $this->taskRepository->find($id);

        if (!$task) {
            return $this->resourceNotFound();
        }

        return $this->view->render('task/edit', ['task' => $task]);
    }

}