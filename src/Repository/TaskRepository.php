<?php

namespace App\Repository;

use App\Model\Task;

class TaskRepository
{
    /**
     * @param array $criteria
     * @param int $offset
     * @param int $limit
     * @return array
     */
    public function findBy(array $criteria = [], int $offset, int $limit): array
    {
        $repo = [
            new Task('john', 'john@gmail.com', 'Do it, John!', '/media/images/john.jpg'),
            new Task('tom', 'tom@gmail.com', 'Do it, Tom!', '/media/images/tom.jpg'),
            new Task('bob', 'bob@gmail.com', 'Do it, Bob!', '/media/images/bob.jpg'),
            new Task('dan', 'dan@gmail.com', 'Do it, Dan!', '/media/images/dan.jpg'),
            new Task('stan', 'stan@gmail.com', 'Do it, Stan!', '/media/images/stan.jpg'),
        ];

        $tasks = array_slice($repo, $offset, $limit, true);

        return $tasks;
    }

}