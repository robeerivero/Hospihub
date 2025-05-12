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
        // Obtener hospitales con su dirección asociada
        $hospitales = DB::table('hospital')
                        ->join('direccion', 'hospital.Id_direccion', '=', 'direccion.Id_direccion')
                        ->select('hospital.Nombre', 'direccion.Ciudad', 'direccion.Calle')
                        ->get();
        return view('eliminar.hospital', compact('hospitales'));
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
        $request->validate([
            'nombre_hospital' => 'required|string|max:255'
        ]);

        try {
            $hospitalExiste = DB::table('hospital')->where('Nombre', $request->nombre_hospital)->exists();

            if (!$hospitalExiste) {
                return redirect()->route('hospitales.eliminar.form')->with([
                    'mensaje' => 'Error: El hospital especificado no existe.',
                    'tipo' => 'error'
                ]);
            }

            // Llamar al procedimiento almacenado para eliminar el hospital
            $resultado = DB::select("CALL Eliminar_Hospital(?)", [$request->nombre_hospital]);

            if (!empty($resultado) && isset($resultado[0]->Mensaje)) {
                $mensaje = $resultado[0]->Mensaje;
                $tipo = ($mensaje === 'Hospital eliminado correctamente') ? 'exito' : 'error';
            } else {
                $mensaje = 'No se recibió respuesta del procedimiento.';
                $tipo = 'error';
            }

        } catch (\Exception $e) {
            $mensaje = 'Error al ejecutar la consulta: ' . $e->getMessage();
            $tipo = 'error';
        }

        return redirect()->route('hospitales.eliminar.form')
                        ->with('mensaje', $mensaje)
                        ->with('tipo', $tipo);
    }
}
