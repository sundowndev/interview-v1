<?php

namespace App\Controller;

use App\Service\JsonResponse;

class DefaultController
{
    private $jsonResponse;

    public function __construct()
    {
        $this->jsonResponse = new JsonResponse();
    }

    /**
     * API homepage
     */
    public function index()
    {
        print $this->jsonResponse->create([
            'code' => 200,
            'message' => 'Hello! :)'
        ], 200);
    }

    /**
     * API 404 not found callback
     */
    public function error()
    {
        print $this->jsonResponse->create([
            'code' => 404,
            'message' => 'Resource not found.'
        ], 404);
    }
}