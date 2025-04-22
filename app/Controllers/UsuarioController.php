<?php
namespace App\Controllers;

use App\Models\UsuariosModel;
use CodeIgniter\Controller;

class UsuarioController extends Controller
{
    public function index()
    {
        return view('usuario/index');
    }

    public function changePassword()
    {
            $userModel=new UsuariosModel();
            $username = session()->get('usuario'); // Obtener el usuario de la sesión           
            $newPassword = $this->request->getPost('np');           
            // Obtener el usuario
            $user = $userModel->getUserData($username);

         
                // Verificar si la nueva contraseña es igual a la actual
                if (password_verify($newPassword, $user['password_usu'])) {
                    return $this->response->setJSON([   
                            
                        'mensaje' => 'La nueva contraseña no puede ser la misma que la actual.'
                      ]);
                }
                // Actualizar la contraseña
                $userModel->updatePassword($username, $newPassword);
                return $this->response->setJSON([
                    'success' => true,
                    'mensaje' => 'Contraseña actualizada con éxito.'
                  ]);
                  session()->set('password',$newPassword );  
            
        

    }
    public function changePasswordUsuario()
    {
            $userModel=new UsuariosModel();
            $codusuario=$this->request->getPost('id');
            $clave= $this->request->getPost('pass');
            $hashedPassword = password_hash($clave, PASSWORD_DEFAULT);           

            try {
                $userModel->update($codusuario, ['password_usu' => $hashedPassword]);
                return $this->response->setJSON(['success' => true, 'message' => 'Password Actualizado.']);
            } catch (\Exception $e) {
                return $this->response->setJSON(['error' => 'Ocurrió un error al actualizar el Password: ' . $e->getMessage()]);
            }
      

    }
}