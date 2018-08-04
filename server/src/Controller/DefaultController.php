<?php

namespace App\Controller;

class DefaultController extends Controller
{
    /**
     * API homepage
     */
    public function index()
    {
        return $this->jsonResponse->create(200, 'Hello! :)');
    }

    /**
     * API 404 not found callback
     */
    public function error()
    {
        return $this->jsonResponse->create(404, 'Resource not found.');
    }
}