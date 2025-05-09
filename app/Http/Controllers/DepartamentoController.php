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

    public function formEditar($id)
    {
        $departamento = DB::select("CALL Obtener_Departamentos_Hospitales_Cursor(?)", [$id]);

        if (!$departamento) {
            return redirect()->route('departamentos.index')->with('error', 'Departamento no encontrado');
        }

        return view('editar.departamento', ['departamento' => $departamento[0]]);
    }

    public function editar(Request $request, $id)
    {
        // Validar los datos del formulario
        $request->validate([
            'nombre_hospital' => 'required|string|max:255',
            'nombre' => 'required|string|max:255',
            'ubicacion' => 'required|string|max:255',
        ]);

        // Recuperar los datos del formulario
        $nombre_hospital = $request->input('nombre_hospital');
        $nombre_departamento = $request->input('nombre');
        $ubicacion = $request->input('ubicacion');

        try {
            // Llamada al procedimiento almacenado para actualizar el departamento
            DB::statement("CALL Editar_Departamento(?, ?, ?, ?)", [$id, $nombre_hospital, $nombre_departamento, $ubicacion]);

            // Redirigir con un mensaje de éxito
            return redirect()->route('departamentos.index')->with([
                'mensaje' => 'Departamento actualizado correctamente.',
                'tipo' => 'exito'
            ]);
        } catch (\Illuminate\Database\QueryException $ex) {
            // Capturar el mensaje de error de la base de datos
            return redirect()->route('departamentos.editar.form', $id)->with([
                'mensaje' => "Error al actualizar el departamento: <br>Hospital no encontrado<br>",
                'tipo' => 'error'
            ]);
        }
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
