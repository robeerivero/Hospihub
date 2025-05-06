<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EliminarHospitalController extends Controller
{
    public function form()
    {
        return view('eliminar.hospital');
    }

    public function eliminar(Request $request)
    {
        $nombre = $request->input('nombre_hospital');
        $mensaje = '';
        $tipo = '';

        try {
            $resultado = DB::select("CALL Eliminar_Hospital(?)", [$nombre]);
            $mensaje = $resultado[0]->Mensaje ?? 'Operación completada.';
            $tipo = ($mensaje === 'Hospital eliminado correctamente') ? 'exito' : 'error';
        } catch (\Illuminate\Database\QueryException $ex) {
            $mensaje = 'No se puede eliminar el hospital. Puede que tenga departamentos asociados.';
            $tipo = 'error';
        }

        return redirect()->route('hospitales.eliminar.form')->with([
            'mensaje' => $mensaje,
            'tipo' => $tipo
        ]);
    }
}
