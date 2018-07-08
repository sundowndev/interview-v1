<?php

$router->setNamespace('\App\Controller');

$router->before('GET|POST', '/.*', function() use ($router) {
    # This will be always executed
});

$router->get('/', 'DefaultController@index');

$router->mount('/tasks', function () use ($router) {
    // get all tasks
    $router->get('/', 'TaskController@getAll');

    // get one task
    $router->get('/(\d+)', 'TaskController@get');

    // create a task
    $router->post('/', 'TaskController@post');

    // update a task
    $router->put('/(\d+)', 'TaskController@put');

    // delete a task
    $router->delete('/(\d+)', 'TaskController@delete');
});

$router->mount('/users', function () use ($router) {
    // endpoints for user
});

$router->set404('DefaultController@error');