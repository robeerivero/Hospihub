<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class HospitalController extends Controller
{
    public function index()
    {
        $hospitales = DB::select("CALL Obtener_Hospitales_Cursor(NULL)");
        return view('hospitales.index', ['hospitales' => $hospitales]);
    }

    public function formEliminar()
    {
        return view('eliminar.hospital');
    }

    public function formInsertar()
    {
        return view('insertar.hospital');
    }

    public function formEditar($id)
    {
        $hospital = DB::select("CALL Obtener_Hospitales_Cursor(?)", [$id]);

        if (!$hospital) {
            return redirect()->route('hospitales.index')->with('error', 'Hospital no encontrado');
        }

        return view('editar.hospital', ['hospital' => $hospital[0]]);
    }

    public function editar(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'ciudad' => 'required|string|max:255',
            'calle' => 'required|string|max:255'
        ]);

        $nombre = $request->input('nombre');
        $ciudad = $request->input('ciudad');
        $calle = $request->input('calle');

        try {
            DB::statement("CALL Editar_Hospital(?, ?, ?, ?)", [$id, $nombre, $ciudad, $calle]);

            return redirect()->route('hospitales.index')->with([
                'mensaje' => 'Hospital actualizado correctamente.',
                'tipo' => 'exito'
            ]);
        } catch (\Illuminate\Database\QueryException $ex) {
            return redirect()->route('hospitales.index')->with([
                'mensaje' => 'Error al actualizar el hospital: ' . $ex->getMessage(),
                'tipo' => 'error'
            ]);
        }
    }

    public function insertar(Request $request)
    {
        $nombre = $request->input('nombre');
        $ciudad = $request->input('ciudad');
        $calle = $request->input('calle');

        try {
            DB::statement("CALL Insertar_Hospital(?, ?, ?)", [$nombre, $ciudad, $calle]);

            return redirect()->route('hospitales.insertar.form')->with([
                'mensaje' => 'Hospital insertado correctamente.',
                'tipo' => 'exito'
            ]);
        } catch (\Illuminate\Database\QueryException $ex) {
            return redirect()->route('hospitales.insertar.form')->with([
                'mensaje' => 'Error al insertar hospital: ' . $ex->getMessage(),
                'tipo' => 'error'
            ]);
        }
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
