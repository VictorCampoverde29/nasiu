<?php

use App\Controllers\EmpresaController;
use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */




$routes->post('/conversor','Home::conversor');
//DASHBOARD
$routes->group('',['filter'=>'AuthFilter'],function($routes){
    $routes->get('/','Home::index');
    $routes->get('dashboard','Home::index');
    $routes->get('bpadres','BarrasPerfilController::ObtenerBarrasPerfilPadres');
   
});

// LOGIN
$routes->group('login',function($routes){
    $routes->get('/', 'LoginController::index');   
    $routes->post('login','LoginController::logueo_ingreso');
    $routes->get('logout', 'LoginController::salir');
    $routes->get('unauthorized', 'LoginController::unauthorized');
});

//CAMBIO DE ALMACEN
$routes->group('acceso',['filter'=>'CambioFilter'],function($routes){
    $routes->get('empresa','AccesoController::get_empresas_acceso');
    $routes->post('sucactivas','SucursalController::get_sucursal_activas');
    $routes->post('almcactivos','AlmacenController::get_almacenes_x_suc');
    $routes->post('cambioalmacen','LoginController::cambio_almacen');
    
});



