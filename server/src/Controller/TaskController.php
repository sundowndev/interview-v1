<?php

namespace App\Controller;

use App\Service\JsonResponse;
use App\Service\Database;

class TaskController
{
    private $jsonResponse;
    private $db;

    public function __construct()
    {
        $this->jsonResponse = new JsonResponse();
        $this->db = new Database();
    }

    /**
     * Get all tasks
     *
     * Route: /task or /task/$page
     * Method: GET
     */
    public function getAll($page = 1)
    {
        print $this->jsonResponse->create([], 200);
    }

    /**
     * Get all tasks
     *
     * Route: /task/$id
     * Method: GET
     */
    public function get($id)
    {
        $code = 200;
        $data = [];

        print $this->jsonResponse->create([
            'code' => $code,
            'data' => $data
        ], $code);
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
        $data = [];

        print $this->jsonResponse->create([
            'code' => $code,
            'data' => $data
        ], $code);
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
        $data = [];

        print $this->jsonResponse->create([
            'code' => $code,
            'data' => $data
        ], $code);
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
        $data = [];

        print $this->jsonResponse->create([
            'code' => $code,
            'data' => $data
        ], $code);
    }
}