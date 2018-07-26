<?php

namespace App\Service;

use App\Repository\SessionRepository;

/**
 * Class Session
 * @package App\Service
 */
class Session
{
    private $db;
    private $sessionRepository;
    public $security;

    /**
     * Session constructor.
     */
    public function __construct(Database $database, JsonResponse $jsonResponse)
    {
        $this->db = $database;
        $this->security = new Security($this, $jsonResponse);
        $this->sessionRepository = new SessionRepository($this->db, $this->security);
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

    /**
     * @return array
     */
    public function getUser()
    {
        return $this->sessionRepository->findUserBySessionToken($this->security->getBearerToken());
    }
}