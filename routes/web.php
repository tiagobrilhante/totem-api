<?php

/** @var Router $router */

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

/** @var Router $router */

use Laravel\Lumen\Routing\Router;

$router->get('/', function () use ($router) {
    return '<h1>API EBTotem</h1> <b>Framework da Api:</b> ' . $router->app->version() . '<br> <b>Versão da api:</b> 1.4<br><b>Desenvolvedor: </b> TC Brilhante <br>Todos os Direitos dessa API pertencem ao Exército Brasileiro. <br> Todo o poder emana do código.';
});

$router->post('/api/login', 'TokenController@gerarToken');

$router->post('/api/totemconfig/admarea', 'TotemConfigController@acesso');
$router->get('/api/totemconfig', 'TotemConfigController@index');
$router->get('/api/assunto/principal', 'AssuntoController@totemPcp');
$router->get('/api/evento/principal', 'EventoController@totemPcp');
$router->get('/api/evento/principal/porpag/{pag}', 'EventoController@pegaPorPag');
$router->get('/api/admquiz/pegaquiz', 'QuizController@pegaQuiz');
$router->get('/api/admquiz/pegaquizpcp/{id}', 'QuizController@pegaQuizCompleto');
$router->post('/api/admquiz/enviarespostas/{id}', 'QuizController@confereRespostas');
$router->post('/api/incrementaacessoassunto', 'AssuntoController@incrementaAcesso');
$router->post('/api/incrementaacessoimagem', 'ImagemController@incrementaAcesso');
$router->post('/api/incrementaacessoevento', 'EventoController@incrementaAcesso');

// autenticado ...
$router->group(['prefix' => 'api', 'middleware' => 'auth'], function () use ($router) {

    // USUARIOS
    $router->group(['prefix' => 'users'], function () use ($router) {

        $router->get('/problemas', 'UserController@verificaProblemas');
        $router->get('', 'UserController@index');
        $router->post('', 'UserController@createUser');
        $router->post('/password/reset', 'UserController@alteraSenhaResetada');
        $router->post('/password/change', 'UserController@alteraSenhaNormal');
        $router->post('/reset/password', 'UserController@resetaSenha');
        $router->post('email/', 'UserController@emailExist');
        $router->put('{id}', 'UserController@update');
        $router->delete('{id}', 'UserController@destroy');


    });

    // Totem Configs
    $router->group(['prefix' => 'totemconfig'], function () use ($router) {
        $router->get('/plus', 'TotemConfigController@plus');
        $router->get('/removebg', 'TotemConfigController@removeBg');
        $router->post('', 'TotemConfigController@store');
        $router->post('/updatebg', 'TotemConfigController@updateBg');

    });

    // Assunto
    $router->group(['prefix' => 'assunto'], function () use ($router) {
        $router->get('', 'AssuntoController@index');
        $router->post('', 'AssuntoController@store');
        $router->delete('{id}', 'AssuntoController@destroy');
        $router->put('{id}', 'AssuntoController@update');
    });

    // Imagem
    $router->group(['prefix' => 'img'], function () use ($router) {

        $router->get('', 'ImagemController@index');
        $router->delete('{id}', 'ImagemController@destroy');
        $router->post('', 'ImagemController@store');
        $router->post('/update', 'ImagemController@update');
        $router->get('/assunto/{id}', 'ImagemController@getImagemAssunto');
    });

    // eventos
    $router->group(['prefix' => 'eventos'], function () use ($router) {
        $router->get('', 'EventoController@index');
        $router->post('', 'EventoController@store');
        $router->post('/update', 'EventoController@update');
        $router->post('/removeimagem', 'EventoController@removeImagem');
        $router->post('/adicionaimgadicional', 'EventoController@addimgadicional');
        $router->delete('{id}', 'EventoController@destroy');
        $router->delete('/deletaimgadicional/{id}', 'EventoController@deletaimgadicional');
    });

    // home
    $router->group(['prefix' => 'home'], function () use ($router) {
        $router->get('', 'HomeController@getInitialStatistics');
    });

    // historico
    $router->group(['prefix' => 'historico'], function () use ($router) {
        $router->get('', 'HistoricoController@index');
    });

    // Estatisticas
    $router->group(['prefix' => 'estatisticas'], function () use ($router) {
        $router->get('{tipo}', 'EstatisticaController@getEstatisticas');
    });

    // bkupbanco
    $router->group(['prefix' => 'bkupbanco'], function () use ($router) {
        $router->get('', 'DatabaseController@getAll');
        $router->get('/gerabkupnovo', 'DatabaseController@geraBkupBancoNovo');
    });

    // admQuiz
    $router->group(['prefix' => 'admquiz'], function () use ($router) {
        $router->get('', 'QuizController@index');
        $router->get('{id}', 'QuizController@get');
        $router->post('', 'QuizController@store');
        $router->put('{id}', 'QuizController@update');
        $router->patch('/status', 'QuizController@ativaDesativa');
        $router->delete('{id}', 'QuizController@destroy');
    });

    // estatisticaQuiz
    $router->group(['prefix' => 'statsquiz'], function () use ($router) {
        $router->get('{id}', 'QuizEstatisticaController@get');
    });

});
