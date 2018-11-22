<?php

namespace App\Database;

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
     * @param Address $address
     * @return bool
     */
    public function insert(Address $address)
    {
        $query = "insert into {$this->table} (label, street, house_number, postal_code, city, country, comments)
            values (:label, :street, :houseNumber, :postalCode, :city, :country, :comments)";
        $stmt = $this->connection->prepare($query);
        $stmt->bindParam(':label', $address->label);
        $stmt->bindParam(':street', $address->street);
        $stmt->bindParam(':houseNumber', $address->houseNumber);
        $stmt->bindParam(':postalCode', $address->postalCode);
        $stmt->bindParam(':city', $address->city);
        $stmt->bindParam(':country', $address->country);
        $stmt->bindParam(':comments', $address->comments);
        return $stmt->execute();
    }
    public function update($id, Address $address)
    {
        $id = (int) $id;
        $fields = $this->mapObjectToArray($address);
        $fieldsToSet = $this->excludeUnchanged($fields, $address->getUpdatedKeys());
        if (!$fieldsToSet) {
            return false;
        }
        $query = "update {$this->table} ";
        $query .= "set " . $this->getQuerySetString($fieldsToSet) . " ";
        $query .= "where id = :id";
        $stmt = $this->connection->prepare($query);
        $stmt->bindParam(':id', $id);
        foreach ($fieldsToSet as $key => $value) {
            $stmt->bindParam(":$key", $value);
        }
        return $stmt->execute();
    }
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
    private function mapObjectToArray(Address $address)
    {
        return [
            'label' => $address->getLabel(),
            'street' => $address->getStreet(),
            'house_number' => $address->getHouseNumber(),
            'postal_code' => $address->getPostalCode(),
            'city' => $address->getCity(),
            'country' => $address->getCountry(),
            'comments' => $address->getComments()
        ];
    }

}