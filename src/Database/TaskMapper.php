<?php

namespace App\Database;

use App\Model\Task;

class TaskMapper
{
    /**
     * @var \PDO
     */
    private $connection;

    /**
     * @var string
     */
    private $table = 'tasks';

    /**
     * TaskMapper constructor.
     * @param \PDO $connection
     */
    public function __construct(\PDO $connection)
    {
        $this->connection = $connection;
    }

    /**
     * @param array $criteria
     * @param int|null $offset
     * @param int|null $limit
     * @param array $sort
     * @return array
     */
    public function select($criteria = [], int $offset = null, int $limit = null, array $sort = [])
    {
        $bindParams = [];

        $sql = "select * from {$this->table}";

        if ($criteria) {
            $whereSql = "";
            array_walk($criteria, function ($value, $key) use (&$whereSql, &$bindParams) {
                $wherePart = "$key=:$key";
                $whereSql .= strlen($whereSql) ? " and " : "";
                $whereSql .= $wherePart;
                $bindParams[":$key"] = $value;
            });
            $sql .= " where $whereSql";
        }

        if ($sort) {
            $sql .= " ORDER BY ";
            foreach ($sort as $key => $value) {
                $sql .= " $key $value ";
            }
        }

        if ($limit) {
            $sql .= " LIMIT $limit";
        }

        if ($offset) {
            $sql .= " OFFSET $offset";
        }

        $stmt = $this->connection->prepare($sql);
        $stmt->execute($bindParams);
        $stmt->setFetchMode(\PDO::FETCH_CLASS, 'App\Model\Task');

        return $stmt->fetchAll();
    }

    /**
     * @param Task $task
     * @return bool
     */
    public function insert(Task $task)
    {
        $query = "insert into {$this->table} (username, email, text)
            values (:username, :email, :text)";
        $stmt = $this->connection->prepare($query);

        $username = $task->getUsername();
        $email = $task->getEmail();
        $text = $task->getText();

        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':text', $text);

        return $stmt->execute();
    }

    public function update($id, Task $task)
    {
        $id = (int) $id;

        $fields = $this->mapObjectToArray($task);
        $fieldsToSet = $this->excludeUnchanged($fields, $task->getUpdatedKeys());

        if (!$fieldsToSet) {
            return false;
        }

        $query = "update {$this->table} ";
        $query .= "set " . $this->getQuerySetString($fieldsToSet) . " ";
        $query .= "where id = :id";

        $stmt = $this->connection->prepare($query);
        $stmt->bindParam(':id', $id);

        foreach ($fieldsToSet as $key => &$value) {
            $stmt->bindParam(":$key", $value);
        }

        return $stmt->execute();
    }

    /**
     * @param $attributes
     * @return string
     */
    private function getQuerySetString($attributes)
    {
        $queryStr = '';
        array_walk($attributes, function ($item, $key) use (&$queryStr) {
            $bind = ':' . $key;
            $queryStr .= strlen($queryStr) ? ',' : '';
            $queryStr .= $key . '=' . $bind;
        });
        return $queryStr;
    }

    /**
     * @param $fields
     * @param $keysOfChanged
     * @return array
     */
    private function excludeUnchanged($fields, $keysOfChanged)
    {
        return array_filter($fields, function ($key) use ($keysOfChanged) {
            return in_array($key, $keysOfChanged);
        }, ARRAY_FILTER_USE_KEY);
    }

    /**
     * @param Task $task
     * @return array
     */
    private function mapObjectToArray(Task $task)
    {
        return [
            'username' => $task->getUsername(),
            'email' => $task->getEmail(),
            'text' => $task->getText(),
            'done' => $task->getDone(),
        ];
    }

}