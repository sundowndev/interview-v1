<?php

namespace App\Repository;

/**
 * Class TaskRepository
 * @package App\Repository
 */
class UserRepository
{
    /**
     * @var Database
     */
    private $db;
    /**
     * @var
     */
    private $tableName;

    /**
     * TaskRepository constructor.
     * @param $db
     */
    public function __construct($db)
    {
        $this->db = $db;
        $this->tableName = 'User';
    }

    /**
     * @return mixed
     */
    public function findAll()
    {
        $stmt = $this->db->getConnection()->prepare('SELECT * FROM ' . $this->tableName . ' ORDER BY id DESC');
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * @param $id
     * @return null
     */
    public function findOneById($id)
    {
        $stmt = $this->db->getConnection()->prepare('SELECT * FROM ' . $this->tableName . ' WHERE id = :id');
        $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
        $stmt->execute();

        $user = $stmt->fetch(\PDO::FETCH_ASSOC);

        if (!$user) {
            return null;
        } else {
            return $user;
        }
    }

    public function findOneByUsername($username)
    {
        $stmt = $this->db->getConnection()->prepare('SELECT * FROM ' . $this->tableName . ' WHERE name = :username');
        $stmt->bindParam(':username', $username, \PDO::PARAM_INT);
        $stmt->execute();

        $user = $stmt->fetch(\PDO::FETCH_ASSOC);

        if (!$user) {
            return null;
        } else {
            return $user;
        }
    }
}