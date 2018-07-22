<?php

namespace App\Service;

/**
 * Class Session
 * @package App\Service
 */
class Session
{
    private $db;
    public $security;

    /**
     * Session constructor.
     */
    public function __construct(Database $database, JsonResponse $jsonResponse)
    {
        $this->db = $database;
        $this->security = new Security($this, $jsonResponse);
    }

    /**
     * @param $user_id
     * @param $csrf
     * @param $cookie
     */
    public function create($user_id)
    {
        $token = $this->security->generateToken();
        $expire_at = new \DateTime();

        $stmt = $this->db->getConnection()->prepare('INSERT INTO Session (user_id, token, issued_at, expire_at) VALUES(:user_id, :token, NOW(), :expire_at)');
        $stmt->bindParam(':user_id', $user_id, \PDO::PARAM_INT);
        $stmt->bindParam(':token', $token, \PDO::PARAM_STR);
        $stmt->bindParam(':expire_at', $expire_at);
        $stmt->execute();
    }

    /**
     * @param $cookie
     * @return mixed|null
     */
    public function getSession($token)
    {
        $stmt = $this->db->getConnection()->prepare('SELECT * FROM Session WHERE token = :token');
        $stmt->bindParam(':token', $token);
        $stmt->execute();

        $session = $stmt->fetch(\PDO::FETCH_ASSOC);

        if (!$session) {
            return null;
        } else {
            return $session;
        }
    }
}