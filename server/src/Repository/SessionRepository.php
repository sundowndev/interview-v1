<?php

namespace App\Repository;

use App\Service\Database;
use App\Service\Security;

/**
 * Class SessionRepository
 * @package App\Repository
 */
class SessionRepository
{
    /**
     * @var Database
     */
    private $db;

    /**
     * @var Security
     */
    private $security;

    /**
     * @var
     */
    private $tableName;

    /**
     * TaskRepository constructor.
     * @param $db
     */
    public function __construct(Database $db, Security $security)
    {
        $this->db = $db;
        $this->security = $security;
        $this->tableName = 'Session';
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

        $task = $stmt->fetch(\PDO::FETCH_ASSOC);

        if (!$task) {
            return null;
        } else {
            return $task;
        }
    }

    public function findUserBySessionToken($token)
    {
        $stmt = $this->db->getConnection()->prepare('SELECT s.token, s.expire_at, u.id, u.name, u.email FROM ' . $this->tableName . ' AS s INNER JOIN User as u ON s.user_id = u.id WHERE s.token = :token');
        $stmt->bindParam(':token', $token, \PDO::PARAM_STR);
        $stmt->execute();

        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    /**
     * @param $user_id
     * @param $csrf
     * @param $cookie
     */
    public function create($user_id, $token, $expiration, $ip)
    {
        $stmt = $this->db->getConnection()->prepare('INSERT INTO Session (`user_id`, `token`, `issued_at`, `expire_at`, `ip_address`) VALUES(:user_id, :token, NOW(), :expire_at, :ip_address)');
        $stmt->bindParam(':user_id', $user_id);
        $stmt->bindParam(':token', $token);
        $stmt->bindParam(':expire_at', $expiration);
        $stmt->bindParam(':ip_address', $ip);
        $stmt->execute();
    }

    /**
     * @param $id
     * @param $data
     * @return mixed
     */
    public function updateById($id, $data)
    {
        $session = $this->findOneById($id);

        /*$stmt = $this->db->getConnection()->prepare('UPDATE ' . $this->tableName . ' SET user_id = :user_id, title = :title, description = :description, creation_date = :creation_date, status = :status');
        $stmt->bindParam(':user_id', $data['user_id'] ?? $task['user_id'], \PDO::PARAM_INT);
        $stmt->bindParam(':title', $data['title'] ?? $task['title'], \PDO::PARAM_STR);
        $stmt->bindParam(':description', $data['description'] ?? $task['description'], \PDO::PARAM_STR);
        $stmt->bindParam(':creation_date', $data['creation_date'] ?? $task['creation_date']);
        $stmt->bindParam(':status', $data['status'] ?? $task['status'], \PDO::PARAM_INT);
        $stmt->execute();

        return $data;*/
    }

    /**
     * @param $id
     */
    public function deleteById($id)
    {
        $stmt = $this->db->getConnection()->prepare('DELETE FROM ' . $this->tableName . ' WHERE id = :id');
        $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
        $stmt->execute();
    }

    /**
     * @param $token
     */
    public function deleteByToken($token)
    {
        $stmt = $this->db->getConnection()->prepare('DELETE FROM ' . $this->tableName . ' WHERE token = :token');
        $stmt->bindParam(':token', $token, \PDO::PARAM_STR);
        $stmt->execute();
    }

    /**
     * @param $userId
     */
    public function deleteByUserId($userId)
    {
        $stmt = $this->db->getConnection()->prepare('DELETE FROM ' . $this->tableName . ' WHERE user_id = :user_id');
        $stmt->bindParam(':user_id', $userId, \PDO::PARAM_INT);
        $stmt->execute();
    }
}