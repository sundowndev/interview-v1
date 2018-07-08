<?php

namespace App\Repository;

use App\Service\Database;

class TaskRepository
{
    private $db;
    private $tableName;

    public function __construct($db)
    {
        $this->db = $db;
        $this->tableName = 'Task';
    }

    public function findAll()
    {
        $stmt = $this->db->getConnection()->prepare('SELECT * FROM ' . $this->tableName . ' ORDER BY id DESC');
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function findOneById($id)
    {
        $stmt = $this->db->getConnection()->prepare('SELECT * FROM ' . $this->tableName . ' WHERE id = :id');
        $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
        $stmt->execute();

        $task = $stmt->fetch(\PDO::FETCH_ASSOC);

        if (!$task) {
            return null;
        } else {
            return $task;
        }
    }

    public function create($data)
    {
        //
    }

    public function updateById($id, $data)
    {
        //
    }

    public function deleteById($id)
    {
        //
    }
}