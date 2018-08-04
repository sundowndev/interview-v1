<?php

namespace App\Controller;

use App\Repository\SessionRepository;
use App\Repository\UserRepository;

class SessionController extends Controller
{
    private $userRepository;
    private $sessionRepository;

    public function __construct()
    {
        parent::__construct();

        $this->userRepository = new UserRepository($this->db);
        $this->sessionRepository = new SessionRepository($this->db, $this->security);
    }

    /**
     * Sign in route
     */
    public function auth()
    {
        $body = $this->request->getContent()->jsonToArray();

        if (empty($body['username']) || empty($body['password'])) {
            return $this->jsonResponse->create(400, 'Please provide an username and password.');
        }

        $user = $this->userRepository->findOneByUsername($body['username']);

        if (is_null($user) || !$this->security->passwordVerify($body['password'], $user['password'])) {
            return $this->jsonResponse->create(403, 'Bad credentials.');
        }

        $token = $this->security->generateToken($user['id']);

        $expire_at = new \DateTime();
        $expire_at->modify('+1 Day'); // Expire in 1 day

        $this->sessionRepository->create($user['id'], $token, $expire_at->format('Y-m-d H:i:s'), $_SERVER['REMOTE_ADDR']);

        return $this->jsonResponse->create(200, 'Welcome ' . $user['name'], [
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
            return $this->jsonResponse->create(400, 'Please provide an username, email and password.');
        }

        $user = [
            'username' => $body['username'],
            'email' => $body['email'],
            'password' => $this->security->passwordHash($body['password']),
        ];

        if (!is_null($this->userRepository->findOneByEmail($user['email']))) {
            return $this->jsonResponse->create(403, 'Email already registered!');
        }

        $this->userRepository->create($user['username'], $user['email'], $user['password']);

        return $this->jsonResponse->create(200, 'Success. Now send your credentials to /auth to sign in.', [
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
            return $this->security->NotAllowedRequest();
        }

        $this->sessionRepository->deleteByToken($this->security->getBearerToken());

        return $this->jsonResponse->create(200, 'Good bye.', []);
    }

    /**
     * Whois route
     */
    public function me()
    {
        if (!$this->security->isLogged()) {
            return $this->security->NotAllowedRequest();
        }

        return $this->jsonResponse->create(200, 'hello!', $this->session->getUser());
    }
}