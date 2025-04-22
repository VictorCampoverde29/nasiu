<?php
namespace App\Controllers;

use App\Models\AlmacenModel;
use App\Models\BarrasPerfilModel;
use App\Models\EmpresaModel;
use App\Models\SucursalModel;
use CodeIgniter\Controller;
use App\Models\UsuariosModel;

class LoginController extends Controller
{
    public function index()
    {
        $session=session();
        if ($session->get('is_logged')) {
            return redirect()->to('/dashboard');
        }
        $usuarios=new  UsuariosModel();
        $empresasCt=new EmpresaModel();
        $data['usuarios']=$usuarios->usuarios_activos();
        $data['empresas']=$empresasCt->get_empresas_activas();
        return view('login/login',$data);
    }

    public function logueo(){
        $session=session();
        if ($session->get('is_logged')) {
            return redirect()->to('/dashboard');
        }
        $usuariosmodel=new UsuariosModel();
        $data['usuariosactivos']=$usuariosmodel->Get_UsuariosActivos();      
        return view('login/login.php',$data);
    }

    public function unauthorized(){
      $data['version']= env('VERSION');
      return view('login/unauthorized.php',$data);
    }
    public function salir(){
      $session=session();
      $session->destroy();
      return redirect()->to('/login');
    }

    public function logueo_ingreso()
    {
    
   
      $clave = $this->request->getPost('clave');
      $usuario = $this->request->getPost('usuario');

      try {
          $usuarioModel = new UsuariosModel();
          $barrasperfilModel=new BarrasPerfilModel();
          // Verifica el usuario y la contraseña
          $userData = $usuarioModel->getUser($usuario, $clave); // Implementa este método en tu modelo
          //log_message('error', 'Datos recibidos: ' . json_encode($userData));

          if ($userData) {
              // Si se encontró el usuario, verifica el acceso
              $url_x_perfil=$barrasperfilModel->geturlsxperfil_aside($userData['perfil']); 
              
                      // Almacena en sesión los datos necesarios
                      session()->set([
                          'nombrepersonal' => $userData['nombre'],
                          'nombreusuariocorto' => $userData['usuario'],          
                          'usuario' => $userData['idusuarios'],
                          'perfil'=>$userData['perfil'],
                          'password' => $clave,                          
                          'urls'=>$url_x_perfil,                    
                          'is_logged'=>true
                      ]);
                    
                      return $this->response->setJSON([
                        'success' => true
                        ]);
  

                  
              
          } else {
            return $this->response->setJSON([
              'success' => false,
              'mensaje' => 'Usuario o Clave Incorrecto'
            ]);
          }
            

      } catch (\Exception $e) {
          return json_encode(['error' => ['text' => $e->getMessage()]]);
      }
    }
    public function cambio_almacen()
    {
    
      $session = session();
        
        if ($session->get('usuario')) {
            $idsucursal = $this->request->getPost('sucursal');
            $idalmacen = $this->request->getPost('almacen');

            $session->set('codsucursal', $idsucursal);
            $session->set('codigoalmacen', $idalmacen);

            $almacenModel = new AlmacenModel();
            $sucursalModel=new SucursalModel();

            // Obtener información del almacén
            $data_almacen = $almacenModel->getAlmacen($idalmacen);           
            $nombalmacen =  $data_almacen['descripcion'];
            
            // Obtener información de la sucursal y empresa
            $data = $sucursalModel->getSucursal($idsucursal);
            log_message('error','Data:'.print_r($data,true));
       
            if ($data) {
              $session->set([
                  'n_sucursal' => $data['suc_descripcion'],   
                  'direccion_suc'=>  $data['direccion_suc'],                
                  'n_empresa' => $data['descripcion_emp'],  
                  'nombrealmacen' => $nombalmacen,
                  'dirempresa' => $data['direccion_emp'],  
                  'rucempresa' => $data['ruc'],  
                  'codempresa' => $data['idempresa'],  
                  'modofe' => $data['modo_ft_notas'],  
                  'modoguias' => $data['modo_guias'],  
                  'usol' => $data['usuario_sol'],  
                  'clavesol' => $data['clavesol'],  
                  'clientid' => $data['clientid'],  
                  'passid' => $data['passid'],  
                  'est_anexo'=> $data['est_anexo']
              ]);
          }


            return $this->response->setJSON([
                'success' => true ,'mensaje'=>'Almacén cambiado correctamente'        ]);
        } else {
            return redirect()->to('login');
        }
    }
}