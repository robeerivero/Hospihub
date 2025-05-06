<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
//Indicar a Laravel que la tabla paciente es una tabla de usuarios
use Illuminate\Foundation\Auth\User as Authenticatable;

class Paciente extends Authenticatable
{
    use HasFactory;

    protected $table = 'paciente';
    protected $fillable = [
        'Nombre', 'Apellidos', 'Telefono', 'Fecha_nacimiento', 'Id_direccion', 'Email', 'PIN'
    ];
    protected $primaryKey = 'Id_paciente';
    protected $hidden = ['PIN'];
    public $timestamps = false; // Desactivar los timestamps automáticos de Laravel

    public function getAuthPassword()
    {
        return $this->PIN;
    }
}
