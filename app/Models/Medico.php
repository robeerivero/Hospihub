<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
//Indicar a Laravel que la tabla paciente es una tabla de usuarios
use Illuminate\Foundation\Auth\User as Authenticatable;

class Medico extends Authenticatable
{
    use HasFactory;

    protected $table = 'medico';
    protected $fillable = [
        'Nombre', 'Apellidos', 'Telefono', 'Fecha_nacimiento', 'Id_departamento', 'Id_direccion', 'Email', 'PIN'
    ];
    protected $primaryKey = 'Id_medico';
    protected $hidden = ['PIN'];
    public $timestamps = false; // Desactivar los timestamps automáticos de Laravel

    public function getAuthPassword()
    {
        return $this->PIN;
    }
}
