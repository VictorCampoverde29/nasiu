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
//RUTAS DE BASE DE DATOS
$routes->group('dashboard',['filter'=>'AuthFilter'],function($routes){
    $routes->get('unidades','UnidadesController::index');
    $routes->get('imp_cert','CertificadosController::imp_cert');
    $routes->get('ing_cert','CertificadosController::ing_cert');
});


// LOGIN
$routes->group('login',function($routes){
    $routes->get('/', 'LoginController::index');   
    $routes->post('login','LoginController::logueo_ingreso');
    $routes->get('logout', 'LoginController::salir');
    $routes->get('unauthorized', 'LoginController::unauthorized');
});


$routes->group('acceso',['filter'=>'CambioFilter'],function($routes){
    /*CAMBIO DE ALMACEN */ 
    $routes->get('empresa','AccesoController::get_empresas_acceso');
    $routes->post('sucursales','AccesoController::get_sucursal_acceso');
    $routes->post('almcactivos','AlmacenController::get_almacenes_x_suc');
    $routes->post('cambioalmacen','LoginController::cambio_almacen');
    $routes->post('clave','UsuarioController::changePassword');
});

$routes->group('certificados',['filter'=>'CambioFilter'],function($routes){
    $routes->post('datatable','CertificadosController::getCertificados');
    $routes->get('rptCertificado/(:num)','CertificadosController::generar_certificado/$1');
    $routes->post('rptCertificados','CertificadosController::generar_certificados_lote');
    $routes->post('guardar_lote','CertificadosController::guardar_lote');

});

$routes->group('usuario',['filter'=>'CambioFilter'],function($routes){
    $routes->post('buscarxid','UsuariosController::buscarxid');
    $routes->post('update','UsuariosController::update');  
    $routes->post('registrar','UsuariosController::insertar'); 
    //MODIFICACION DESDE DASHBOARD
    $routes->post('cambiopass','UsuarioController::changePasswordUsuario'); 
});

$routes->group('unidades',['filter'=>'CambioFilter'],function($routes){
    $routes->get('datatable','UnidadesController::getall');
    $routes->post('insertar','UnidadesController::insertar');
    $routes->post('buscarxid','UnidadesController::buscarxid');
    $routes->post('update','UnidadesController::update');  
});

$routes->group('documentacion',['filter'=>'CambioFilter'],function($routes){
    $routes->post('insertar','DocumentacionController::insertar');
    $routes->post('datatable','DocumentacionController::get_all_x_unidades');  
    $routes->post('actualizar','DocumentacionController::update');
    $routes->get('vencidos','DocumentacionController::get_all_vencidos');
});


//API CONSULTAS
$routes->group('api',['filter'=>'CambioFilter'],function($routes){
    $routes->post('unidades','ApiController::ConsultarPLaca');
});


