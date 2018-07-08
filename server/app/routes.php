<?php

$router->setNamespace('\App\Controller');

$router->before('GET|POST', '/.*', function() use ($router) {
    # This will be always executed
});

$router->get('/', 'DefaultController@index');

$router->mount('/product', function () use ($router) {
    $router->get('/', 'TaskController@getAll');
});

$router->set404('DefaultController@error');