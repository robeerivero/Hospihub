<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Hospital extends Model
{
    protected $table = 'Hospital'; // nombre exacto de tu tabla
    protected $primaryKey = 'Id_hospital'; // clave primaria
    public $timestamps = false; // porque no tienes campos created_at / updated_at
}
