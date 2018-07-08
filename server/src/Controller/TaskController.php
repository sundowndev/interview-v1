<?php

namespace App\Controller;

use App\Service\JsonResponse;
use App\Service\Database;
use App\Repository\TaskRepository;

class TaskController
{
    private $jsonResponse;
    private $db;

    public function __construct()
    {
        $this->jsonResponse = new JsonResponse();
        $this->db = new Database();
        $this->repository = new TaskRepository($this->db);
    }

    /**
     * Get all tasks
     *
     * Route: /task
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
     * Get all tasks
     *
     * Route: /task/$id
     * Method: GET
     */
    public function get($id)
    {
        $data = $this->repository->findOneById($id) ?? [];
        $code = ($data != null) ? 200 : 404;
        $message = ($data != null) ? "Task found." : "Task not found.";

        //var_dump($data);

        print $this->jsonResponse->create($code, $message, $data);
    }

    /**
     * Create a task
     *
     * Route: /task
     * Method: POST
     */
    public function post()
    {
        $code = 200;
        $message = "";
        $data = [];

        print $this->jsonResponse->create($code, $message, $data);
    }

    /**
     * Update a task
     *
     * Route: /task/$id
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
     * Route: /task/$id
     * Method: DELETE
     */
    public function delete($id)
    {
        $code = 200;
        $message = "";
        $data = [];

        print $this->jsonResponse->create($code, $message, $data);
    }
}