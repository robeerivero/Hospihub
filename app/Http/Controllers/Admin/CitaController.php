<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class CitaController extends Controller
{
    public function index()
    {
        $citas = DB::select('CALL Obtener_Citas()');
        return view('admin.citas.index', compact('citas'));
    }

    public function crearTodas()
    {
        $resultados = DB::select('CALL Crear_Citas()');
        return view('admin.citas.crear', ['mensajes' => $resultados]);
    }

    public function eliminarTodas()
    {
        DB::table('Cita')->delete();
        return view('admin.citas.eliminar');
    }
}
?>