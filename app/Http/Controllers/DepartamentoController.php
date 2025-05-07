<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class DepartamentoController extends Controller
{
    public function index()
    {
        $departamentos = DB::select("CALL Obtener_Departamentos_Hospitales_Cursor(NULL)");
        return view('departamentos.index', ['departamentos' => $departamentos]);
    }

    public function formEliminar()
    {
        return view('eliminar.departamento');
    }

    public function formInsertar()
    {
        return view('insertar.departamento');
    }

    public function insertar(Request $request)
    {
        $request->validate([
            'nombre_hospital' => 'required|string|max:255',
            'nombre_departamento' => 'required|string|max:255',
            'ubicacion' => 'required|string|max:255',
        ]);

        try {
            DB::statement("CALL Insertar_Departamento(?, ?, ?)", [
                $request->nombre_hospital,
                $request->nombre_departamento,
                $request->ubicacion
            ]);

            return redirect()->route('departamentos.insertar.form')->with([
                'mensaje' => 'Departamento registrado correctamente.',
                'tipo' => 'exito'
            ]);

        } catch (\Exception $e) {
            return redirect()->route('departamentos.insertar.form')->with([
                'mensaje' => 'Error: ' . $e->getMessage(),
                'tipo' => 'error'
            ]);
        }
    }


    public function eliminar(Request $request)
    {
        $request->validate([
            'id_departamento' => 'required|integer|min:1'
        ]);

        $mensaje = '';
        $tipo = '';

        try {
            $resultado = DB::select("CALL Eliminar_Departamento(?)", [$request->id_departamento]);

            if (!empty($resultado) && isset($resultado[0]->Mensaje)) {
                $mensaje = $resultado[0]->Mensaje;
                $tipo = $mensaje === 'Departamento eliminado correctamente' ? 'exito' : 'error';
            } else {
                $mensaje = 'No se recibió respuesta de la función.';
                $tipo = 'error';
            }

        } catch (\Exception $e) {
            $mensaje = 'Error al ejecutar la consulta.';
            $tipo = 'error';
        }

        return redirect()->route('departamentos.eliminar.form')
                         ->with('mensaje', $mensaje)
                         ->with('tipo', $tipo);
    }
}
