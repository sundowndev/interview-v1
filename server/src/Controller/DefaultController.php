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
        print $this->jsonResponse->create(200, 'Hello! :)');
    }

    /**
     * API 404 not found callback
     */
    public function error()
    {
        print $this->jsonResponse->create(404, 'Resource not found.');
    }
}