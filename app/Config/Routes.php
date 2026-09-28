<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

$routes->get('api/manuel/livres/(:num)', 'Api\LivresManuel::show/$1');
$routes->resource('api/livres', ['except' => 'new,edit']);
