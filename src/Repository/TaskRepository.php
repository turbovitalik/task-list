<?php

namespace App\Repository;

use App\Model\Task;

class TaskRepository
{
    protected $repo = [];

    public function __construct()
    {
        $this->repo = [
            new Task('john', 'john@gmail.com', 'Do it, John!', '/media/images/john.jpg'),
            new Task('tom', 'tom@gmail.com', 'Do it, Tom!', '/media/images/tom.jpg'),
            new Task('bob', 'bob@gmail.com', 'Do it, Bob!', '/media/images/bob.jpg'),
            new Task('dan', 'dan@gmail.com', 'Do it, Dan!', '/media/images/dan.jpg'),
            new Task('stan', 'stan@gmail.com', 'Do it, Stan!', '/media/images/stan.jpg'),
            new Task('john', 'john@gmail.com', 'Do it, John!', '/media/images/john.jpg'),
            new Task('tom', 'tom@gmail.com', 'Do it, Tom!', '/media/images/tom.jpg'),
            new Task('bob', 'bob@gmail.com', 'Do it, Bob!', '/media/images/bob.jpg'),
            new Task('dan', 'dan@gmail.com', 'Do it, Dan!', '/media/images/dan.jpg'),
            new Task('stan', 'stan@gmail.com', 'Do it, Stan!', '/media/images/stan.jpg'),
        ];
    }


    /**
     * @param array $criteria
     * @param int $offset
     * @param int $limit
     * @return array
     */
    public function findBy(int $offset, int $limit, array $sortBy = []): array
    {
        $tasks = array_slice($this->repo, $offset, $limit, true);

        usort($tasks, function ($a, $b) {

            if ($a->getUsername() == $b->getUsername()) {
                return 0;
            }

            return ($a->getUsername() < $b->getUsername()) ? -1 : 1;
        });

        return $tasks;
    }

    public function addTask(Task $task)
    {
        $this->repo[] = $task;
    }

    public function findAll()
    {
        return $this->repo;
    }


}