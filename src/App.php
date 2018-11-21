<?php

namespace App;

use PDO;

class App
{
    /**
     * @var PDO
     */
    protected $db;

    /**
     * App constructor.
     * @param PDO $db
     */
    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function run()
    {
        $sql = "select * from tasks";
        $stmt = $this->db->query($sql, PDO::FETCH_ASSOC);

        $result = $stmt->fetchAll();

        var_dump($result);
    }
}