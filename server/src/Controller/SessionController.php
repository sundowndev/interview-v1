<?php

namespace App\Controller;

use App\Repository\UserRepository;
use App\Service\Database;
use App\Service\JsonResponse;
use App\Service\Request;
use App\Service\Session;

class SessionController
{
    private $db;
    private $jsonResponse;
    private $request;
    private $session;
    private $security;
    private $userRepository;

    public function __construct()
    {
        $this->db = new Database();
        $this->request = new Request();
        $this->jsonResponse = new JsonResponse();
        $this->session = new Session($this->db, $this->jsonResponse);
        $this->security = $this->session->security;
        $this->userRepository = new UserRepository($this->db);
    }

    /**
     * Sign in route
     */
    public function auth()
    {
        $content = $this->request->getContentAsArray();

        if (empty($content['username']) || empty($content['password'])) {
            print $this->jsonResponse->create(400, 'Please provide an username and password.');
            exit();
        }

        $user = $this->userRepository->findOneByUsername($content['username']);

        if (!$this->security->passwordVerify($content['password'], $user['password'])) {
            print $this->jsonResponse->create(403, 'Bad credentials.');
            exit();
        }

        $token = $this->security->generateToken();

        $expire_at = new \DateTime();
        $expire_at->add(new \DateInterval('P1D')); // Expire in 1 day

        $stmt = $this->db->getConnection()->prepare('INSERT INTO Session (`user_id`, `token`, `issued_at`, `expire_at`) VALUES(:user_id, :token, NOW(), :expire_at)');
        $stmt->bindParam(':user_id', $user['id']);
        $stmt->bindParam(':token', $token);
        $stmt->bindParam(':expire_at', date_format($expire_at, 'Y-m-d'));
        $stmt->execute();

        print $this->jsonResponse->create(200, 'Welcome ' . $user['name'], [
            'jwt_token' => $token,
            'expire_at' => $expire_at,
        ]);
    }

    /**
     * Register route
     */
    public function signup()
    {
        $content = json_decode(trim(file_get_contents("php://input")), true);

        if (empty($content['username']) || empty($content['email']) || empty($content['password'])) {
            print $this->jsonResponse->create(400, 'Please provide an username, email and password.');
            exit();
        }

        $user = [
            'username' => $content['username'],
            'email' => $content['email'],
            'password' => $this->security->passwordHash($content['password']),
        ];

        $stmt = $this->db->getConnection()->prepare('INSERT INTO User (`name`, `email`, `password`) VALUES(:name, :email, :password)');
        $stmt->bindParam(':name', $user['username']);
        $stmt->bindParam(':email', $user['email']);
        $stmt->bindParam(':password', $user['password']);
        $stmt->execute();

        print $this->jsonResponse->create(200, 'Success! Now send your credentials to /auth to sign in.', [
            'username' => $user['username'],
            'email' => $user['email'],
        ]);
    }

    public function signout()
    {
        // logout
    }
}