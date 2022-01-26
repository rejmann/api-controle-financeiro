<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

use Laravel\Lumen\Routing\Router;

/** @var Router $router */
$router->get('/', function () use ($router) {
    return $router->app->version();
});

/**
 * Grupo de rotas para receitas
 */
$router->group(['prefix' => 'receitas'], function () use ($router) {

    $router->get('', 'MovimentController@index');
    $router->get('{id}', 'MovimentController@show');
    $router->post('', 'MovimentController@store');
    $router->put('{id}', 'MovimentController@update');

});

/**
 * Grupo de rotas para despesas
 */
$router->group(['prefix' => 'despesas'], function () use ($router) {

    $router->get('', 'MovimentController@index');
    $router->get('{id}', 'MovimentController@show');
    $router->post('', 'MovimentController@store');
    $router->put('{id}', 'MovimentController@update');

});


