<?php

/** @var \Laravel\Lumen\Routing\Router $router */

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

/** @var \Laravel\Lumen\Routing\Router  $router */

$router->get('/', function () use ($router) {
    return $router->app->version();
});


$router->post('/api/login', 'TokenController@gerarToken');



$router->group(['prefix' => 'api', 'middleware' => 'auth' ], function () use ($router){

    $router->group(['prefix'=>'om'], function () use ($router){

        $router->post( '', 'OmController@store');
        $router->get( '', 'OmController@index');
        $router->get( 'disponivel', 'OmController@omsDisponives');
        $router->get( '{id}', 'OmController@show');
        $router->put( '{id}', 'OmController@update');
        $router->delete( '{id}', 'OmController@destroy');

    });

    $router->group(['prefix'=>'users'], function () use ($router){

        $router->post( '', 'UserController@store');
        $router->post( 'create', 'UserController@createUser');
        $router->post( '/password/reset', 'UserController@alteraSenhaResetada');
        $router->post( '/reset/password', 'UserController@resetaSenha');
        $router->get( '', 'UserController@index');
        $router->get( '{id}', 'UserController@show');
        $router->put( '{id}', 'UserController@update');
        $router->delete( '{id}', 'UserController@destroy');
        $router->post( 'cpf/', 'UserController@cpfExist');
        $router->post( 'tiposdisponiveis', 'UserController@retornaTipo');


    });

});
