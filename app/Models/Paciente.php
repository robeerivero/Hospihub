<?php
namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable; // ⬅ Añadir esto
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Paciente extends Authenticatable
{
    use HasFactory, Notifiable; // ⬅ Añadir Notifiable

    protected $table = 'paciente';
    protected $primaryKey = 'Id_paciente';
    public $timestamps = false;

    protected $fillable = [
        'Nombre', 'Apellidos', 'Telefono', 'Fecha_nacimiento', 'Id_direccion', 'Email', 'PIN'
    ];

    protected $hidden = ['PIN'];

    // Para notificaciones por correo
    public function routeNotificationForMail()
    {
        return $this->Email; // ← Usa el campo real del correo
    }

    // Para el saludo en el email
    public function getNameAttribute()
    {
        return "{$this->Nombre} {$this->Apellidos}";
    }

    public function getAuthPassword()
    {
        return $this->PIN;
    }
}
