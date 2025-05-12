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
        DB::select('CALL Crear_Citas()');
        return redirect()->route('admin.citas.exito');
    }

    public function eliminarTodas()
    {
        DB::table('Cita')->delete();
        return view('admin.citas.eliminar_exito');
    }
}
?>