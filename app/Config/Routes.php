<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

$routes->get('/app', 'Home::index');
$routes->get('/app/login', 'Home::loginapi');
$routes->get('/app/register', 'Home::registerapi');
$routes->get('/app/update_user', 'Home::update_user');
$routes->get('/app/config_game', 'Home::config_game');
$routes->get('/app/update_config_game', 'Home::update_config_game');
$routes->get('/app/add_game', 'Home::add_game');
$routes->get('/app/last_games', 'Home::last_games');
$routes->get('/app/user_stats', 'Home::user_stats');
$routes->get('/app/top_users', 'Home::top_users');






$routes->get("test", "ApiController::test", ['filter' => 'jwt']);
$routes->get("test", "ApiController::test", ['filter' => 'jwt:CONFIG_POLICY']);
$routes->get("test", "ApiController::test", ['filter' => 'jwt:test']);

$routes->post('apis/V1/create_user', 'ApiController::create_user');
$routes->post('apis/V1/login', 'ApiController::login');
$routes->get('apis/V1/logged', 'ApiController::logged', ['filter' => 'jwt']);
$routes->post('apis/V1/update_user', 'ApiController::update_user', ['filter' => 'jwt']);
$routes->post('apis/V1/logout', 'ApiController::logout', ['filter' => 'jwt']);
$routes->post('apis/V1/config_game', 'ApiController::config_game', ['filter' => 'jwt']);
$routes->post('apis/V1/update_config_game', 'ApiController::update_config_game', ['filter' => 'jwt']);
$routes->post('apis/V1/add_game', 'ApiController::add_game', ['filter' => 'jwt']);
$routes->get('apis/V1/get_user_last_games', 'ApiController::get_user_last_games', ['filter' => 'jwt']);
$routes->get('apis/V1/get_user_stats', 'ApiController::get_user_stats', ['filter' => 'jwt']);
$routes->get('apis/V1/get_top_users', 'ApiController::get_top_users');


//$routes->options('apis/V1/(:any)', static function(){});

$routes->options('apis/V1/(:any)', function() {
    // Estableix les capçaleres CORS per la resposta OPTIONS
    return service('response')
        ->setHeader('Access-Control-Allow-Origin', '*')  // Permet a tots els dominis
        ->setHeader('Access-Control-Allow-Methods', 'GET, POST, OPTIONS, PATCH, PUT, DELETE')
        ->setHeader('Access-Control-Allow-Headers', 'X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Requested-Method, Authorization')
        ->setStatusCode(200);  // Retorna un estat 200
});

