<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->post('/login', 'User::login');
$routes->get('/debit_list', 'Debit::list');
$routes->post('/debit_list', 'Debit::add_debit');
$routes->delete('/debit_list/(:num)', 'Debit::remove_debit/$1');
$routes->put('/debit_list/(:num)', 'Debit::edit_debit/$1');
$routes->get('/vehicle_and_employee', 'Debit::vehicle_and_employee_list');
