<?php

use App\Service\DotEnvParser;
use App\Service\JsonResponse;

$router->setNamespace('\App\Controller');

$router->before('GET|POST|PUT|DELETE', '/.*', function () use ($router) {
    # This will be always executed
    $dotEnvParser = new DotEnvParser();
    $dotEnvParser->run();

    $jsonResponse = new JsonResponse();

    if ($_SERVER['HTTP_ACCEPT'] !== 'application/json') {
        $code = 400;
        $message = 'Accept header is not set to "application/json".';
        print $jsonResponse->create($code, $message, []);
        exit();
    } elseif ($_SERVER['REQUEST_METHOD'] != 'GET' && $_SERVER['CONTENT_TYPE'] !== 'application/json') {
        $code = 400;
        $message = 'Content-type header is not set to "application/json".';
        print $jsonResponse->create($code, $message, []);
        exit();
    }/* elseif ($_SERVER['HTTP_ORIGIN'] !== getenv('ALLOW_ORIGIN')) {
        $code = 403;
        $message = 'Unallowed origin.';
        print $jsonResponse->create($code, $message, []);
        exit();
    }*/
});

/**
 * API index
 */
$router->get('/', 'DefaultController@index');

/**
 * Session handling routes
 */
$router->post('/auth', 'SessionController@auth');
$router->post('/register', 'SessionController@signup');
$router->post('/logout', 'SessionController@signout');

/**
 * Task resource
 */
$router->mount('/tasks', function () use ($router) {
    // Get all tasks
    $router->get('/', 'TaskController@getAll');

    // Get one task
    $router->get('/(\d+)', 'TaskController@get');

    // Create a task
    $router->post('/', 'TaskController@post');

    // Update a task
    $router->put('/(\d+)', 'TaskController@put');

    // Delete a task
    $router->delete('/(\d+)', 'TaskController@delete');
});

/**
 * User resource
 */
$router->mount('/users', function () use ($router) {
    // Create user (register)
    $router->post('/', 'DefaultController@index');

    // Get your own account data
    $router->get('/me', 'DefaultController@index');

    // Get one user
    $router->get('/(\d+)', 'DefaultController@index');

    // Get one task's tasks
    $router->get('/(\d+)/tasks', 'DefaultController@index');
});

/**
 * 404 error response
 */
$router->set404('DefaultController@error');
