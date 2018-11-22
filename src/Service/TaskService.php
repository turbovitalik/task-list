<?php

namespace App\Service;

use App\Repository\TaskRepository;

class TaskService
{
    protected $repository;

    public function __construct(TaskRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @return array
     */
    public function getTaskList(int $itemsPerPage, int $page = 0, array $sortBy = []): array
    {
        $offset = $page ? ($page - 1) * $itemsPerPage : 0;

        $tasks = $this->repository->findBy($offset, $itemsPerPage, $sortBy);

        return $tasks;
    }
}