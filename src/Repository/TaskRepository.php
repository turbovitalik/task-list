<?php

namespace App\Repository;

use App\Database\TaskMapper;
use App\Model\Task;

class TaskRepository
{
    /**
     * @var TaskMapper
     */
    private $mapper;

    /**
     * TaskRepository constructor.
     * @param TaskMapper $mapper
     */
    public function __construct(TaskMapper $mapper)
    {
        $this->mapper = $mapper;
    }

    /**
     * @param int $offset
     * @param int $limit
     * @param array $sortBy
     * @return array
     */
    public function findBy(int $offset, int $limit, array $sortBy = []): array
    {
        return $this->mapper->select([], $offset, $limit, $sortBy);
    }

    /**
     * @param Task $task
     */
    public function add(Task $task)
    {
        $this->mapper->insert($task);
    }

    /**
     * @param $id
     * @param $data
     * @return bool
     */
    public function update(int $id, array $data)
    {
        $task = $this->find($id);

        if (!$task) {
            return false;
        }

        $task->populateWith($data);
        $this->mapper->update($id, $task);

        return true;
    }

    /**
     * @return array
     */
    public function findAll()
    {
        return $this->mapper->select([]);
    }

    /**
     * @param int $id
     * @return Task
     */
    public function find(int $id)
    {
        $result = $this->mapper->select(['id' => $id]);

        return $result[0];
    }
}