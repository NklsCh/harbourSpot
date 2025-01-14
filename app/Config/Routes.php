<?php
use CodeIgniter\Router\RouteCollection;
/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

$routes->get('register', 'Auth::indexRegister');
$routes->post('register', 'Auth::handleRegister');

$routes->get('login', 'Auth::indexLogin');
$routes->post('login', 'Auth::handleLogin');

$routes->get('logout', 'Auth::logout');

$routes->get('berths', 'Berths::index');
$routes->get('berths/details/(:num)', 'Berths::details/$1');
$routes->post('berths/rent', 'Berths::rent');
$routes->get('berths-status', 'Home::getBerthStatus');
$routes->get('berths-status/(:any)', 'Home::getBerthStatus/$1');


$routes->get('migrate', 'Migrate::index');
