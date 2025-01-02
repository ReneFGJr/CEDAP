<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Cedap::index');
$routes->get('/dci', 'Dci::index');
$routes->get('/dci/(:any)', 'Dci::index/$1');
$routes->post('/dci/(:any)', 'Dci::index/$1');
