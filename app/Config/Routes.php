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
