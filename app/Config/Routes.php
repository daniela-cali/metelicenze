<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'HomeController::index');

service('auth')->routes($routes);


$routes->group('database', function($routes) {
    $routes->get('/', 'DatabaseInfoController::index');
    $routes->get('doppiodb', 'DatabaseInfoController::doppiodb'); 
    $routes->get('info', 'DatabaseInfoController::info');
    $routes->get('fields/(:segment)', 'DatabaseInfoController::getTableFields/$1');
});



$routes->group('clienti', function($routes) {
    $routes->get('/', 'ClientiController::index');
    $routes->get('schedaCliente/(:num)', 'ClientiController::schedaCliente/$1');
 });

$routes->group('licenze', function($routes) {
    $routes->get('/', 'LicenzeController::index');
    $routes->get('crea/(:num)', 'LicenzeController::crea/$1'); // Nuova licenza per IDCliente
    $routes->get('modifica/(:num)', 'LicenzeController::modifica/$1');
    $routes->get('elimina/(:num)', 'LicenzeController::elimina/$1');
    $routes->get('visualizza/(:num)', 'LicenzeController::visualizza/$1');
    $routes->post('salva/(:num)/', 'LicenzeController::salva/$1'); // Salva licenza per IDCliente
    $routes->post('salva/(:num)/(:num)/', 'LicenzeController::salva/$1/$2'); // Salva licenza per IDCliente e IDLicenza   
});

$routes->group('aggiornamenti', function($routes) {
    $routes->get('crea/(:num)', 'AggiornamentiController::crea/$1');
});

$routes->group('api', function($routes) {
    $routes->get('aggiornamenti/licenza/(:num)', 'AggiornamentiController::jsonByLicenza/$1');
    

 });