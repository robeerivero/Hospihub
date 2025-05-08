<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class MedicoController extends Controller
{
    public function index()
    {
        $medicos = DB::select("CALL Obtener_Medicos_Cursor(NULL)");
        return view('medicos.index', ['medicos' => $medicos]);
    }

    public function formEliminar()
    {
        return view('eliminar.medico');
    }

    public function formInsertar()
    {
        return view('insertar.medico');
    }

    public function insertar(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string',
            'apellidos' => 'required|string',
            'telefono' => 'required|string',
            'fecha' => 'required|date',
            'ciudad' => 'required|string',
            'calle' => 'required|string',
            'email' => 'required|email',
            'pin' => 'required|string',
            'hospital' => 'required|string',
            'departamento' => 'required|string',
        ]);

        $mensaje = '';
        $tipo = '';

        try {
            $pinHasheado = bcrypt($request->input('pin'));

            DB::statement("CALL Insertar_Medico(?, ?, ?, ?, ?, ?, ?, ?, ?, ?)", [
                $request->input('hospital'),
                $request->input('departamento'),
                $request->input('nombre'),
                $request->input('apellidos'),
                $request->input('telefono'),
                $request->input('fecha'),
                $request->input('ciudad'),
                $request->input('calle'),
                $request->input('email'),
                $pinHasheado,
            ]);

            $mensaje = 'Médico registrado correctamente.';
            $tipo = 'exito';
        } catch (\Exception $e) {
            $mensaje = 'Error al registrar médico: ' . $e->getMessage();
            $tipo = 'error';
        }

        return redirect()->back()->with(['mensaje' => $mensaje, 'tipo' => $tipo]);
    }


    public function eliminar(Request $request)
    {
        $email = $request->input('email_medico');
        $mensaje = '';
        $tipo = '';

        try {
            $resultado = DB::select("CALL Eliminar_Medico(?)", [$email]);

            if (isset($resultado[0]->Mensaje)) {
                $mensaje = $resultado[0]->Mensaje;
                $tipo = ($mensaje === 'Médico eliminado correctamente') ? 'exito' : 'error';
            } else {
                $mensaje = 'No se recibió respuesta del procedimiento.';
                $tipo = 'error';
            }
        } catch (\Exception $e) {
            $mensaje = 'Error al ejecutar el procedimiento.';
            $tipo = 'error';
        }

        return back()->with(['mensaje' => $mensaje, 'tipo' => $tipo]);
    }
}
