<?php
use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
$routes->setDefaultNamespace('App\\Controllers');
$routes->setDefaultController('ConteudoController');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->setAutoRoute(false);

$routes->get('/', 'ConteudoController::index');
$routes->get('home', 'ConteudoController::index');
$routes->get('contato', 'ConteudoController::contato');

service('auth')->routes($routes);

$routes->group('', ['filter' => 'session'], static function ($routes) {
    $routes->get('conteudos', 'ConteudoController::listar');
    $routes->get('conteudos/editar/(:num)', 'ConteudoController::editar/$1');
    $routes->post('conteudos/atualizar/(:num)', 'ConteudoController::atualizar/$1');
    $routes->post('admin/sair', 'Admin\\Painel::logout');
});

$routes->group('admin', ['filter' => ['session', 'group:admin']], static function ($routes) {
    $routes->get('/', 'Admin\\Painel::index');
    $routes->get('conteudos', 'Admin\\Painel::conteudos');
    $routes->get('conteudos/editar/(:num)', 'Admin\\Painel::editar/$1');
    $routes->post('conteudos/atualizar/(:num)', 'Admin\\Painel::atualizar/$1');
});