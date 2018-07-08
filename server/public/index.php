<?php

require_once __DIR__.'/../vendor/autoload.php';

$router = new \Bramus\Router\Router();

require __DIR__.'/../app/routes.php';

$router->run();