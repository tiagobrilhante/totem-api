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

/** @var \Laravel\Lumen\Routing\Router $router */

$router->get('/', function () use ($router) {
    return $router->app->version();
});


$router->post('/api/login', 'TokenController@gerarToken');


$router->post('/api/myip', 'IpController@myIp');

$router->group(['prefix' => 'api', 'middleware' => 'auth'], function () use ($router) {

    $router->group(['prefix' => 'om'], function () use ($router) {

        $router->post('', 'OmController@store');
        $router->get('', 'OmController@index');
        $router->get('disponivel', 'OmController@omsDisponives');
        $router->get('{id}', 'OmController@show');
        $router->put('{id}', 'OmController@update');
        $router->delete('{id}', 'OmController@destroy');

    });

    $router->group(['prefix' => 'panels'], function () use ($router) {

        $router->post('', 'PanelController@store');
        $router->get('', 'PanelController@index');
        $router->get('load', 'PanelController@indexLoad');
        $router->get('showpanel', 'PanelController@showPanel');
        $router->get('{id}', 'PanelController@show');
        $router->put('{id}', 'PanelController@update');
        $router->delete('{id}', 'PanelController@destroy');

    });

    $router->group(['prefix' => 'tipoatendimento'], function () use ($router) {

        $router->get('alltipos', 'TipoAtendimentoController@tiposOm');
        $router->post('', 'TipoAtendimentoController@store');
        $router->get('', 'TipoAtendimentoController@index');
        $router->get('{id}', 'TipoAtendimentoController@show');
        $router->put('{id}', 'TipoAtendimentoController@update');
        $router->delete('{id}', 'TipoAtendimentoController@destroy');

    });

    $router->group(['prefix' => 'parametronormal'], function () use ($router) {

        $router->post('', 'ChamadaNormalParametrosController@store');
        $router->get('', 'ChamadaNormalParametrosController@index');
        $router->get('last', 'ChamadaNormalParametrosController@last');

    });
    $router->group(['prefix' => 'parametroprioridade'], function () use ($router) {

        $router->post('', 'ChamadaPrioridadeParametrosController@store');
        $router->get('', 'ChamadaPrioridadeParametrosController@index');
        $router->get('last', 'ChamadaPrioridadeParametrosController@last');


    });
    $router->group(['prefix' => 'parametrochamada'], function () use ($router) {

        $router->get('checa', 'ParametroChamadaController@verificaParametros');

    });

    $router->group(['prefix' => 'chamadas'], function () use ($router) {

        $router->get('mycalls/normal', 'ChamadasController@myCallsNormal');
        $router->get('mycalls/preferencial', 'ChamadasController@myCallsPreferencial');
        $router->get('mycalls/nominal', 'ChamadasController@myCallsNominal');
        $router->get('previsao', 'ChamadasController@previsaoChamada');
        $router->post('chama', 'ChamadasController@geraChamada');
        $router->get('aberto', 'ChamadasController@checaAberto');
        $router->get('descarta/{id}', 'ChamadasController@descartaAtiva');
        $router->post('finaliza', 'ChamadasController@finalizaAtiva');
        $router->get('rechamada/{id}', 'ChamadasController@rechamadaAtiva');

    });

    $router->group(['prefix' => 'guiches'], function () use ($router) {

        $router->post('', 'GuicheController@store');
        $router->get('load', 'GuicheController@indexLoad');
        $router->get('', 'GuicheController@index');
        $router->get('myguiche', 'GuicheController@myGuiche');
        $router->get('{id}', 'GuicheController@show');
        $router->put('{id}', 'GuicheController@update');
        $router->delete('{id}', 'GuicheController@destroy');

    });

    $router->group(['prefix' => 'users'], function () use ($router) {

        $router->post('', 'UserController@store');
        $router->post('create', 'UserController@createUser');
        $router->post('/password/reset', 'UserController@alteraSenhaResetada');
        $router->post('/reset/password', 'UserController@resetaSenha');
        $router->get('', 'UserController@index');
        $router->get('{id}', 'UserController@show');
        $router->put('{id}', 'UserController@update');
        $router->delete('{id}', 'UserController@destroy');
        $router->post('cpf/', 'UserController@cpfExist');
        $router->post('tiposdisponiveis', 'UserController@retornaTipo');


    });

});
