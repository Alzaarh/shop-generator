<?php

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->group(['prefix' => 'auth', 'namespace' => 'Auth', 'middleware' => 'guest'],
function () use ($router)
{
    $router->post('/signup', ['as' => 'auth.signup', 'uses' => 'AuthController@signup']);

    $router->get('/verify', ['as' => 'auth.verify', 'uses' => 'AuthController@verify']);

    $router->post('/signin', ['as' => 'auth.signin', 'uses' => 'AuthController@signin']);
});

