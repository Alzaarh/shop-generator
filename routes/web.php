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

$router->group(['prefix' => 'categories', 'namespace' => 'Product'],
function () use ($router)
{
    $router->get('/', ['as' => 'categories.index', 'uses' => 'CategoriesController@index']);

    $router->get('/{id}', ['as' => 'categories.show', 'uses' => 'CategoriesController@show']);

    $router->post('/', ['as' => 'categories.create', 'uses' => 'CategoriesController@create']);

    $router->put('/{id}', ['as' => 'categories.update', 'uses' => 'CategoriesController@update']);

    $router->delete('/{id}', ['as' => 'categories.delete', 'uses' => 'CategoriesController@delete']);
});

