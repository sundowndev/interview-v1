<?php

namespace App\Controller;

use App\Service\Database;
use App\Service\JsonResponse;
use App\Service\Request;
use App\Service\Session;

/**
 * Class Controller
 * @package App\Controller
 */
class Controller
{

    /**
     * @var Database
     */
    protected $db;

    /**
     * @var JsonResponse
     */
    protected $jsonResponse;

    /**
     * @var Request
     */
    protected $request;

    /**
     * @var Session
     */
    protected $session;

    /**
     * @var \App\Service\Security
     */
    protected $security;

    /**
     * Controller constructor.
     */
    public function __construct()
    {
        $this->db = new Database();
        $this->request = new Request();
        $this->jsonResponse = new JsonResponse();
        $this->session = new Session($this->db, $this->jsonResponse);
        $this->security = $this->session->security;
    }
}