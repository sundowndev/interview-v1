<?php

namespace App\Controller;

use App\Service\JsonResponse;
use App\Service\Database;
use App\Repository\TaskRepository;
use App\Service\Request;
use App\Service\Session;

/**
 * Class TaskController
 * @package App\Controller
 */
class TaskController
{
    private $db;
    private $request;
    private $jsonResponse;
    private $session;
    private $security;
    private $repository;

    public function __construct()
    {
        $this->db = new Database();
        $this->request = new Request();
        $this->jsonResponse = new JsonResponse();
        $this->repository = new TaskRepository($this->db);
        $this->session = new Session($this->db, $this->jsonResponse);
        $this->security = $this->session->security;
    }

    /**
     * Get all tasks
     *
     * Route: /tasks
     * Method: GET
     */
    public function getAll()
    {
        $code = 200;
        $message = "Here are the tasks!";
        $data = $this->repository->findAll();

        print $this->jsonResponse->create($code, $message, $data);
    }

    /**
     * Get task by id
     *
     * Route: /tasks/$id
     * Method: GET
     */
    public function get($id)
    {
        $data = $this->repository->findOneById($id) ?? [];
        $code = ($data != null) ? 200 : 404;
        $message = ($data != null) ? "Task found." : "Task not found.";

        print $this->jsonResponse->create($code, $message, $data);
    }

    /**
     * Create a task
     *
     * Route: /tasks
     * Method: POST
     */
    public function post()
    {
        if (!$this->security->isLogged()) {
            print $this->security->NotAllowedRequest();
            exit();
        }

        $content = $this->request->getContentAsArray();

        if (empty($content['title']) || empty($content['description'])) {
            $code = 400;
            $message = 'Bad parameters.';

            print $this->jsonResponse->create($code, $message);
            exit();
        }

        $task = $this->repository->create([
            'user_id' => 1,
            'title' => $content['title'],
            'description' => $content['description'],
            'status' => 1
        ]);

        $code = 200;
        $message = 'Success!';
        $data = $task;

        print $this->jsonResponse->create($code, $message, $data);
    }

    /**
     * Update a task
     *
     * Route: /tasks/$id
     * Method: PUT
     */
    public function put($id)
    {
        $code = 200;
        $message = "";
        $data = [];

        print $this->jsonResponse->create($code, $message, $data);
    }

    /**
     * Delete a task
     *
     * Route: /tasks/$id
     * Method: DELETE
     */
    public function delete($id)
    {
        if (!$this->security->isLogged()) {
            print $this->security->NotAllowedRequest();
            exit();
        }

        $task = $this->repository->findOneById($id);

        if ($task['user_id'] !== 1) {
            print $this->security->NotAllowedRequest();
            exit();
        }

        $this->repository->deleteById($id);

        $code = 200;
        $message = "Task deleted.";
        $data = [];

        print $this->jsonResponse->create($code, $message, $data);
    }
}