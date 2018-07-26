<?php

namespace App\Controller;

use App\Repository\TaskRepository;
use App\Service\Database;
use App\Service\JsonResponse;
use App\Repository\UserRepository;

class UserController
{
    private $db;
    private $jsonResponse;
    private $repository;
    private $taskRepository;

    public function __construct()
    {
        $this->db = new Database();
        $this->jsonResponse = new JsonResponse();
        $this->repository = new UserRepository($this->db);
        $this->taskRepository = new TaskRepository($this->db);
    }

    /**
     * Get user by id
     *
     * Route: /users/$id
     * Method: GET
     */
    public function get($id)
    {
        $user = $this->repository->findOneById($id) ?? [];
        $code = ($user != null) ? 200 : 404;
        $message = ($user != null) ? "User found." : "User not found.";

        print $this->jsonResponse->create($code, $message, [
            'id' => $user['id'],
            'username' => $user['name'],
            'email' => $user['email'],
        ]);
    }

    public function getTasks($id)
    {
        $user = $this->repository->findOneById($id) ?? [];

        if (is_null($user)) {
            $code = ($data != null) ? 200 : 404;
            $message = ($data != null) ? "User found." : "User not found.";

            print $this->jsonResponse->create($code, $message, []);
            exit();
        }

        $tasks = $this->taskRepository->findByUserId($id);

        print $this->jsonResponse->create(200, 'Here are the tasks.', $tasks);
    }
}