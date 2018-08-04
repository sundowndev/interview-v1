<?php

namespace App\Controller;

use App\Repository\TaskRepository;

/**
 * Class TaskController
 * @package App\Controller
 */
class TaskController extends Controller
{
    private $repository;

    public function __construct()
    {
        parent::__construct();

        $this->repository = new TaskRepository($this->db);
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

        return $this->jsonResponse->create($code, $message, $data);
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

        return $this->jsonResponse->create($code, $message, $data);
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
            return $this->security->NotAllowedRequest();
        }

        $body = $this->request->getContent()->jsonToArray();

        if (empty($body['title']) || empty($body['description'])) {
            $code = 400;
            $message = 'Bad parameters.';

            return $this->jsonResponse->create($code, $message);
        }

        $user = $this->session->getUser();

        $task = $this->repository->create([
            'user_id' => $user['id'],
            'title' => $body['title'],
            'description' => $body['description'],
            'status' => 1
        ]);

        $code = 200;
        $message = 'Success!';
        $data = $task;

        return $this->jsonResponse->create($code, $message, $data);
    }

    /**
     * Update a task
     *
     * Route: /tasks/$id
     * Method: PUT
     */
    public function put($id)
    {
        if (!$this->security->isLogged()) {
            return $this->security->NotAllowedRequest();
        }

        $task = $this->repository->findOneById($id);
        $user = $this->session->getUser();

        if ($task['user_id'] !== $user['id']) {
            return $this->security->NotAllowedRequest();
        }

        $body = $this->request->getContent()->jsonToArray();

        $task = $this->repository->updateById($id, [
            'title' => $body['title'] ?? $task['title'],
            'description' => $body['description'] ?? $task['description'],
            'status' => $body['status'] ?? $task['status']
        ]);

        $code = 200;
        $message = "Task edited.";
        $data = $task;

        return $this->jsonResponse->create($code, $message, $data);
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
            return $this->security->NotAllowedRequest();
        }

        $task = $this->repository->findOneById($id);
        $user = $this->session->getUser();

        if ($task['user_id'] !== $user['id']) {
            return $this->security->NotAllowedRequest();
        }

        $this->repository->deleteById($id);

        $code = 200;
        $message = "Task deleted.";
        $data = [];

        return $this->jsonResponse->create($code, $message, $data);
    }
}