<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
// Auth Routes
$routes->post('register', 'Auth::register');
$routes->post('login', 'Auth::login');
$routes->get('logout', 'Auth::logout');
$routes->post('auth/register', 'Auth::register');

// Load URL helper globally
helper('url');

