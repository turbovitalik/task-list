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
    public function getTaskList(int $offset, int $perPage): array
    {
        $tasks = $this->repository->findBy([], $offset, $perPage);


        return $tasks;
    }
}