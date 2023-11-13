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

$router->get('/api/contawhat', 'EstatisticaWhatController@conta');

// autenticado ...
$router->group(['prefix' => 'api', 'middleware' => 'auth'], function () use ($router) {

    // Om
    $router->group(['prefix' => 'oms'], function () use ($router) {

        $router->get('/lepais', 'OmController@getPais');
        $router->get('', 'OmController@mostra');
        $router->get('{id}', 'OmController@show');
        $router->get('/chart/{id}', 'OmController@getChart');
        $router->delete('{id}', 'OmController@deleta');
        $router->post('', 'OmController@salva');
        $router->put('{id}', 'OmController@altera');
    });

    // Secao
    $router->group(['prefix' => 'secoes'], function () use ($router) {

        $router->get('/lepais', 'SecaoController@getPais');
        $router->get('/secoespermitidas/{id}', 'SecaoController@secoespermitidas');
        $router->get('', 'SecaoController@index');
        $router->get('{id}', 'SecaoController@show');
        $router->get('/le/subord/{id_conseq}', 'SecaoController@pegaSubord');
        $router->get('/chart/{id}', 'SecaoController@getChart');
        $router->delete('{id}', 'SecaoController@destroy');

        $router->post('', 'SecaoController@salva');
        $router->put('{id}', 'SecaoController@altera');
    });

    // USUARIOS
    $router->group(['prefix' => 'users'], function () use ($router) {

        $router->post('', 'UserController@store');
        $router->post('create', 'UserController@createUser');
        $router->post('/password/reset', 'UserController@alteraSenhaResetada');
        $router->post('/password/change', 'UserController@alteraSenhaNormal');
        $router->post('/reset/password', 'UserController@resetaSenha');
        $router->get('', 'UserController@index');
        $router->get('{id}', 'UserController@show');
        $router->put('{id}', 'UserController@update');
        $router->delete('{id}', 'UserController@destroy');
        $router->post('cpf/', 'UserController@cpfExist');
        $router->post('tiposdisponiveis', 'UserController@retornaTipo');


    });

    // INATIVO
    $router->group(['prefix' => 'inativo'], function () use ($router) {

        $router->get('', 'InativoController@index');
        $router->get('{id}', 'InativoController@show');
        $router->delete('{id}', 'InativoController@deleta');
        $router->post('', 'InativoController@salva');
        $router->put('{id}', 'InativoController@edita');
        $router->post('cpf/', 'InativoController@cpfExist');
        $router->post('busca/', 'InativoController@searchInativo');
    });

    // DEPENDENTE
    $router->group(['prefix' => 'dep'], function () use ($router) {

        $router->get('', 'DependenteController@lista');
        $router->post('cpf/', 'DependenteController@cpfExist');
        $router->post('salva/', 'DependenteController@salva');
        $router->delete('{id}', 'DependenteController@destroy');
        $router->put('altera/{id}', 'DependenteController@altera');
        $router->post('busca/', 'DependenteController@searchDependente');
    });

    // postograd
    $router->group(['prefix' => 'postograd'], function () use ($router) {

        $router->get('', 'PostoGradController@mostrar');
        $router->get('{id}', 'PostoGradController@show');
        $router->delete('{id}', 'PostoGradController@destroy');
        $router->post('', 'PostoGradController@store');
        $router->put('{id}', 'PostoGradController@update');
    });

    // sit mil
    $router->group(['prefix' => 'sitmil'], function () use ($router) {

        $router->get('', 'SitMilController@index');
        $router->get('{id}', 'SitMilController@show');
        $router->delete('{id}', 'SitMilController@destroy');
        $router->post('', 'SitMilController@store');
        $router->put('{id}', 'SitMilController@update');
    });

    // UA pagadora
    $router->group(['prefix' => 'ua'], function () use ($router) {

        $router->get('', 'UaPagadoraController@index');
        $router->get('{id}', 'UaPagadoraController@show');
        $router->delete('{id}', 'UaPagadoraController@destroy');
        $router->post('', 'UaPagadoraController@store');
        $router->put('{id}', 'UaPagadoraController@update');
    });

    // situação
    $router->group(['prefix' => 'sit'], function () use ($router) {

        $router->get('', 'SituacaoController@index');
        $router->get('{id}', 'SituacaoController@show');
        $router->delete('{id}', 'SituacaoController@destroy');
        $router->post('', 'SituacaoController@store');
        $router->put('{id}', 'SituacaoController@update');
    });

    // Parentesco
    $router->group(['prefix' => 'parent'], function () use ($router) {

        $router->get('', 'ParentescoController@index');
        $router->get('{id}', 'ParentescoController@show');
        $router->delete('{id}', 'ParentescoController@destroy');
        $router->post('', 'ParentescoController@store');
        $router->put('{id}', 'ParentescoController@update');
    });

    // tcu Status
    $router->group(['prefix' => 'tcustatus'], function () use ($router) {

        $router->get('', 'TcuStatusController@index');
        $router->get('{id}', 'TcuStatusController@show');
        $router->delete('{id}', 'TcuStatusController@destroy');
        $router->post('', 'TcuStatusController@store');
        $router->put('{id}', 'TcuStatusController@update');
    });

    // Inativo Observação
    $router->group(['prefix' => 'observacao'], function () use ($router) {

        $router->delete('{id}', 'InativoObservacaoController@delete');
        $router->post('', 'InativoObservacaoController@salva');
        $router->put('{id}', 'InativoObservacaoController@altera');
    });

    // dependente Observação
    $router->group(['prefix' => 'depobs'], function () use ($router) {

        $router->delete('{id}', 'DependenteObservacaoController@delete');
        $router->post('', 'DependenteObservacaoController@salva');
        $router->put('{id}', 'DependenteObservacaoController@altera');
    });

    // Andamento do processo
    $router->group(['prefix' => 'ap'], function () use ($router) {

        $router->delete('{id}', 'AndamentoProcessoController@deleta');
        $router->post('', 'AndamentoProcessoController@salva');
        $router->put('{id}', 'AndamentoProcessoController@altera');
    });

    // Processo Tipo
    $router->group(['prefix' => 'proctipo'], function () use ($router) {

        $router->get('', 'ProcessoTipoController@mostra');
        $router->delete('{id}', 'ProcessoTipoController@deleta');
        $router->post('', 'ProcessoTipoController@salva');
        $router->put('{id}', 'ProcessoTipoController@altera');
        $router->get('consulta/{id}', 'ProcessoTipoController@consultaDeletar');
    });

    // Docs Exigencia
    $router->group(['prefix' => 'docexig'], function () use ($router) {

        $router->delete('{id}', 'ProcessoExigenciaController@deleta');
        $router->post('', 'ProcessoExigenciaController@salva');
        $router->put('{id}', 'ProcessoExigenciaController@altera');
    });

    // Processo Status
    $router->group(['prefix' => 'procstatus'], function () use ($router) {

        $router->get('', 'ProcessoStatusController@show');
        $router->delete('{id}', 'ProcessoStatusController@deleta');
        $router->post('', 'ProcessoStatusController@salva');
        $router->put('{id}', 'ProcessoStatusController@altera');
    });

    // Processo Sit Mil
    $router->group(['prefix' => 'procsitmil'], function () use ($router) {

        $router->get('', 'ProcessoSitMilController@show');
        $router->delete('{id}', 'ProcessoSitMilController@deleta');
        $router->post('', 'ProcessoSitMilController@salva');
        $router->put('{id}', 'ProcessoSitMilController@altera');
    });

    // Om do isntituidor
    $router->group(['prefix' => 'omintrs'], function () use ($router) {

        $router->get('', 'ProcessoOmIntrsController@show');

    });


});
