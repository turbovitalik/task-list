<?php

namespace App\Repository;

use App\Core\Paginator;
use App\Database\TaskMapper;
use App\Model\Task;

class TaskRepository
{
    protected $repo = [];

    public function __construct(TaskMapper $mapper)
    {
        $this->mapper = $mapper;
    }

//    public function __construct()
//    {
//        $this->repo = [
//            new Task(1, 'john', 'john@gmail.com', 'Do it, John!', '/media/images/john.jpg'),
//            new Task(2, 'tom', 'tom@gmail.com', 'Do it, Tom!', '/media/images/tom.jpg'),
//            new Task(3, 'bob', 'bob@gmail.com', 'Do it, Bob!', '/media/images/bob.jpg'),
//            new Task(4, 'dan', 'dan@gmail.com', 'Do it, Dan!', '/media/images/dan.jpg'),
//            new Task(5, 'stan', 'stan@gmail.com', 'Do it, Stan!', '/media/images/stan.jpg'),
//            new Task(6, 'john', 'john@gmail.com', 'Do it, John!', '/media/images/john.jpg'),
//            new Task(7, 'tom', 'tom@gmail.com', 'Do it, Tom!', '/media/images/tom.jpg'),
//            new Task(8, 'bob', 'bob@gmail.com', 'Do it, Bob!', '/media/images/bob.jpg'),
//            new Task(9, 'dan', 'dan@gmail.com', 'Do it, Dan!', '/media/images/dan.jpg'),
//            new Task(10, 'stan', 'stan@gmail.com', 'Do it, Stan!', '/media/images/stan.jpg'),
//        ];
//    }


    /**
     * @param array $criteria
     * @param int $offset
     * @param int $limit
     * @return array
     */
//    public function findBy(int $offset, int $limit, array $sortBy = []): array
//    {
//        $tasks = array_slice($this->repo, $offset, $limit, true);
//
//        usort($tasks, function ($a, $b) {
//
//            if ($a->getUsername() == $b->getUsername()) {
//                return 0;
//            }
//
//            return ($a->getUsername() < $b->getUsername()) ? -1 : 1;
//        });
//
//        return $tasks;
//    }

    public function findBy(int $offset, int $limit, array $sortBy = []): array
    {
        return $this->mapper->select([], $offset, $limit, $sortBy);
    }

    public function addTask(Task $task)
    {
        $this->repo[] = $task;
    }

    public function update($id, $data)
    {
        $task = $this->find($id);

        if (!$task) {
            return false;
        }

        $task->save($data);

        // Replace

        array_walk($this->repo, function (&$item) use ($task, $id) {
            if ($item->getId() == $id) {
                $item = $task;
                return;
            }
        });

        return true;
    }

//    public function findAll()
//    {
//        return $this->repo;
//    }

    public function findAll()
    {
        return $this->mapper->select([]);
    }

    public function find($id)
    {
        foreach ($this->repo as $task) {
            if ($task->getId() == $id) {
                return $task;
            }
        }
    }


}