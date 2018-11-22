<?php

namespace App\Service;

use App\Repository\TaskRepository;

class TaskService
{
    //todo: duplication
    const ITEMS_PER_PAGE = 3;

    protected $repository;

    public function __construct(TaskRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @return array
     */
    public function getTaskList(int $page, array $sortBy = []): array
    {
        $offset = $page ? ($page - 1) * self::ITEMS_PER_PAGE : 0;

        $tasks = $this->repository->findBy($offset, self::ITEMS_PER_PAGE, $sortBy);

        return $tasks;
    }
}