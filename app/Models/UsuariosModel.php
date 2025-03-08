<?php

namespace App\Models;

use CodeIgniter\Model;

class UsuariosModel extends Model
{
    protected $table      = 'usuarios';
    protected $primaryKey = 'idusuarios';
    protected $allowedFields = ['usuario','clave','estado','perfil'];  

    public function usuarios_activos()
    {
        return $this->select('usuario')
                    ->where('estado','ACTIVO')
                    ->findAll();
    }
}