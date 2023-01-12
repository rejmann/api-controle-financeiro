<?php

use Laravel\Lumen\Routing\Router;

/**
 * @var Router $router
 */
$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->group(['prefix' => 'api'], function () use ($router) {
    $router->post('login', 'LoginController@index');

    $router->post('cadastrar', 'UserController@store');

    $router->group(['middleware' => 'auth'], function () use ($router) {

        $router->group(['prefix' => 'receitas'], function () use ($router) {
            $router->get('', 'MovimentController@indexRevenueAction');
            $router->get('{id}', 'MovimentController@showRevenueAction');
            $router->post('', 'MovimentController@storeRevenueAction');
            $router->get('{year}/{month}', 'MovimentController@showRevenueByMonth');
            $router->put('{id}', 'MovimentController@updateRevenueAction');
            $router->delete('{id}', 'MovimentController@destroy');
        });

        $router->group(['prefix' => 'despesas'], function () use ($router) {
            $router->get('', 'MovimentController@indexExpenseAction');
            $router->get('{id}', 'MovimentController@showExpenseAction');
            $router->post('', 'MovimentController@storeExpenseAction');
            $router->get('{year}/{month}', 'MovimentController@showExpenseByMonth');
            $router->put('{id}', 'MovimentController@updateExpenseAction');
            $router->delete('{id}', 'MovimentController@destroy');
        });

        $router->get('resumo/{year}/{month}', 'ResumeController@index');
    });
});
