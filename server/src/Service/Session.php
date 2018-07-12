<?php

namespace App\Service;

/**
 * Class Session
 * @package App\Service
 */
class Session
{
    /**
     * Session constructor.
     */
    public function __construct()
    {
        $this->db = new Database();
    }

    /**
     * @param $user_id
     * @param $csrf
     * @param $cookie
     */
    public function create($user_id, $csrf, $cookie)
    {
        $stmt = $this->db->getConnection()->prepare('INSERT INTO Session (user_id, csrf, cookie) VALUES(:user_id, :csrf, :cookie)');
        $stmt->bindParam(':user_id', $user_id, \PDO::PARAM_INT);
        $stmt->bindParam(':title', $csrf, \PDO::PARAM_STR);
        $stmt->bindParam(':description', $cookie, \PDO::PARAM_STR);
        $stmt->execute();
    }

    /**
     * @param $cookie
     * @return mixed|null
     */
    public function getSession($cookie)
    {
        $stmt = $this->db->getConnection()->prepare('SELECT * FROM Session WHERE cookie = :cookie');
        $stmt->bindParam(':cookie', $cookie);
        $stmt->execute();

        $session = $stmt->fetch(\PDO::FETCH_ASSOC);

        if (!$session) {
            return null;
        } else {
            return $session;
        }
    }
}