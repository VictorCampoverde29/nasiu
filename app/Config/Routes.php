<?php

use App\Controllers\EmpresaController;
use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('/login', 'LoginController::index');
$routes->get('/empresa','EmpresaController::index');


$routes->post('/conversor','Home::conversor');
$routes->get('/prueba','EmpresaController::ver_empresas_activas');


$routes->group('login',function($routes){
    $routes->get('sucactivas','SucursalController::get_sucursal_activas');
    $routes->get('almcactivos','AlmacenController::get_almacenes_x_suc');
});


$routes->group('',['filter'=>'AuthFilter'],function($routes){

    $routes->get('/usuario','UsuarioController::index');
});
