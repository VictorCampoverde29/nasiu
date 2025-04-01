<?php
namespace App\Controllers;

use App\Models\BarrasPerfilModel;
use App\Models\EmpresaModel;
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
      return view('login/unauthorized.php');
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
          log_message('info', 'Datos recibidos: ' . json_encode($userData));

          if ($userData) {
              // Si se encontró el usuario, verifica el acceso
              $url_x_perfil=$barrasperfilModel->geturlsxperfil_aside($userData['perfil']); 
              
                      // Almacena en sesión los datos necesarios
                      session()->set([
                          'nombreusuariocorto' => $userData['usuario'],          
                          'usuario' => $userData['idusuarios'],
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
}