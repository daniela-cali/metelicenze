<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'HomeController::index');

service('auth')->routes($routes);


$routes->group('database', ['filter' => 'group:superadmin,admin'], function($routes) {
    $routes->get('/', 'DatabaseInfoController::connectionTest'); 
    $routes->get('info/(:segment)', 'DatabaseInfoController::info/$1');
    $routes->get('fields/(:segment)/(:segment)', 'DatabaseInfoController::getTableFields/$1/$2'); 
    /*
     * Visualizza i campi di una tabella specifica
     * Esempio: /database/fields/nome_database/nome_tabella
     */
    $routes->get('showlog', 'DatabaseInfoController::showLog');

});

$routes->group('filters', ['filter' => 'notpending'], function($routes) {
    $routes->get('/', 'FiltersController::index');
    $routes->post('apply', 'FiltersController::applyFilters');
    $routes->get('clear', 'FiltersController::clearFilters');
 });

$routes->group('clienti', ['filter' => 'notpending'], function($routes) {
    $routes->post('filters', 'ClientiController::clientiFilters');
    $routes->get('/', 'ClientiController::index');
    $routes->get('schedaCliente/(:num)', 'ClientiController::schedaCliente/$1');
 });

$routes->group('licenze', ['filter' => 'notpending'], function($routes) {
    $routes->get('/', 'LicenzeController::index');
    $routes->get('crea/(:num)', 'LicenzeController::crea/$1'); // Nuova licenza per IDCliente
    $routes->get('modifica/(:num)', 'LicenzeController::modifica/$1');
    $routes->get('elimina/(:num)', 'LicenzeController::elimina/$1');
    $routes->get('visualizza/(:num)', 'LicenzeController::visualizza/$1');
    $routes->post('salva/(:num)/', 'LicenzeController::salva/$1'); // Salva licenza per IDCliente
    $routes->post('salva/(:num)/(:num)/', 'LicenzeController::salva/$1/$2'); // Salva licenza per IDCliente e IDLicenza   
});

$routes->group('aggiornamenti',['filter' => 'notpending'], function($routes) {
    $routes->get('index/(:num)', 'AggiornamentiController::getByLicenza/$1');
    $routes->get('crea/(:num)', 'AggiornamentiController::crea/$1');
    $routes->get('modifica/(:num)', 'AggiornamentiController::modifica/$1');
    $routes->get('visualizza/(:num)', 'AggiornamentiController::visualizza/$1'); // Visualizza aggiornamento per ID
    $routes->post('salva/(:num)', 'AggiornamentiController::salva/$1'); // Salva aggiornamento per ID
});
$routes->group('versioni', ['filter' => 'notpending'], function($routes) {
    $routes->get('/', 'VersioniController::index');
    $routes->get('crea', 'VersioniController::crea');
    $routes->get('modifica/(:num)', 'VersioniController::modifica/$1');
    $routes->get('elimina/(:num)', 'VersioniController::elimina/$1');
    $routes->get('visualizza/(:num)', 'VersioniController::visualizza/$1');
    $routes->post('salva/(:num)', 'VersioniController::salva/$1'); // Salva versione per IDVersione
    $routes->post('salva', 'VersioniController::salva'); // Salva nuova versione
});

$routes->group('admin', function($routes) {
    $routes->get('settings', 'Admin\SettingsController::index');
    $routes->post('settings/save', 'Admin\SettingsController::save');

});
$routes->get('aggiornamentiModel/(:segment)', 'TestController::aggiornamentiModel/$1', ['filter' => 'session']);
$routes->group('test', function($routes) {
    $routes->get('aggiornamentiModel/(:segment)', '');
    $routes->get('log', 'TestController::logTestMessage');
    $routes->get('db', 'TestController::testDatabaseConnection');
});


$routes->get('account-pending', 'AccountController::pending');

$routes->group('utenti', ['filter' => 'group:superadmin,admin'], function($routes) {
    $routes->get('/', 'UsersController::index');
    $routes->get('crea', 'UsersController::crea');
    $routes->get('modifica/(:num)', 'UsersController::modifica/$1');
    $routes->get('elimina/(:num)', 'UsersController::elimina/$1');
    $routes->get('visualizza/(:num)', 'UsersController::visualizza/$1');
    $routes->post('salva/(:num)', 'UsersController::salva/$1');
    $routes->get('approva/(:num)', 'UsersController::approva/$1');
    $routes->get('changePassword', 'UsersController::changePassword');
    $routes->post('changePassword', 'UsersController::changePassword');
});