<?php

namespace App\Database;

use PDO;

class Mysql
{
    /**
     * @var PDO
     */
    protected $connection;

    /**
     * Mysql constructor.
     * @param string $host
     * @param string $db
     * @param string $user
     * @param string $password
     */
    public function __construct(string $host, string $db, string $user, string $password)
    {
        try {
            $pdo = new PDO('mysql:host=' . $host . ';dbname=' . $db, $user, $password);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (\PDOException $e) {
            throw new \Exception('Sorry, Mysql connection error!');
        }

        $this->connection = $pdo;
    }

    /**
     * @return PDO
     */
    public function getConnection()
    {
        return $this->connection;
    }
}