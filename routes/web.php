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
        $router->get( '{id}', 'OmController@show');
        $router->put( '{id}', 'OmController@update');
        $router->delete( '{id}', 'OmController@destroy');

       // $router->get( 'users', 'OmController@withusers');

        $router->get( '{serieId}/episodios', 'EpisodiosController@buscaPorSerie');

    });

    $router->group(['prefix'=>'users'], function () use ($router){

        $router->post( '', 'UserController@store');
        $router->get( '', 'UserController@index');
        $router->get( '{id}', 'UserController@show');
        $router->put( '{id}', 'UserController@update');
        $router->delete( '{id}', 'UserController@destroy');
        $router->post( 'cpf', 'UserController@cpfExist');


    });

    $router->group(['prefix'=>'usertypes'], function () use ($router){

        $router->post( '', 'UserTypeController@store');
        $router->get( '', 'UserTypeController@index');
        $router->get( '{id}', 'UserTypeController@show');
        $router->put( '{id}', 'UserTypeController@update');
        $router->delete( '{id}', 'UserTypeController@destroy');

       // $router->get( 'users', 'UserTypeController@withusers');


    });

    $router->group(['prefix'=>'episodios'], function () use ($router){

        $router->post( '', 'EpisodiosController@store');
        $router->get( '', 'EpisodiosController@index');
        $router->get( '{id}', 'EpisodiosController@show');
        $router->put( '{id}', 'EpisodiosController@update');
        $router->delete( '{id}', 'EpisodiosController@destroy');

    });

});
