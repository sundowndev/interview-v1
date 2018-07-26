<?php

namespace App\Controller;

use App\Repository\SessionRepository;
use App\Repository\UserRepository;
use App\Service\Database;
use App\Service\JsonResponse;
use App\Service\Request;
use App\Service\Session;

class SessionController
{
    private $db;
    private $jsonResponse;
    private $sessionRepository;
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
        $this->sessionRepository = new SessionRepository($this->db, $this->security);
        $this->userRepository = new UserRepository($this->db);
    }

    /**
     * Sign in route
     */
    public function auth()
    {
        $body = $this->request->getContent()->jsonToArray();

        if (empty($body['username']) || empty($body['password'])) {
            print $this->jsonResponse->create(400, 'Please provide an username and password.');
            exit();
        }

        $user = $this->userRepository->findOneByUsername($body['username']);

        if (is_null($user) || !$this->security->passwordVerify($body['password'], $user['password'])) {
            print $this->jsonResponse->create(403, 'Bad credentials.');
            exit();
        }

        $token = $this->security->generateToken($user['id']);

        $expire_at = new \DateTime();
        $expire_at->modify('+1 Day'); // Expire in 1 day

        $this->sessionRepository->create($user['id'], $token, $expire_at->format('Y-m-d H:i:s'), $_SERVER['REMOTE_ADDR']);

        print $this->jsonResponse->create(200, 'Welcome ' . $user['name'], [
            'token' => $token,
            'expire_at' => $expire_at,
        ]);
    }

    /**
     * Register route
     */
    public function signup()
    {
        $body = $this->request->getContent()->jsonToArray();

        if (empty($body['username']) || empty($body['email']) || empty($body['password'])) {
            print $this->jsonResponse->create(400, 'Please provide an username, email and password.');
            exit();
        }

        $user = [
            'username' => $body['username'],
            'email' => $body['email'],
            'password' => $this->security->passwordHash($body['password']),
        ];

        if (!is_null($this->userRepository->findOneByEmail($user['email']))) {
            print $this->jsonResponse->create(403, 'Email already registered!');
            exit();
        }

        $this->userRepository->create($user['username'], $user['email'], $user['password']);

        print $this->jsonResponse->create(200, 'Success. Now send your credentials to /auth to sign in.', [
            'username' => $user['username'],
            'email' => $user['email'],
        ]);
    }

    /**
     * Signout
     */
    public function signout()
    {
        if (!$this->security->isLogged()) {
            print $this->security->NotAllowedRequest();
            exit();
        }

        $this->sessionRepository->deleteByToken($this->security->getBearerToken());

        print $this->jsonResponse->create(200, 'Good bye.', []);
    }

    /**
     * Whois route
     */
    public function me()
    {
        if (!$this->security->isLogged()) {
            print $this->security->NotAllowedRequest();
            exit();
        }

        print $this->jsonResponse->create(200, 'hello!', $this->session->getUser());
    }
}