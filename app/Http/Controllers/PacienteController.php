<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Paciente;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;

class PacienteController extends Controller
{
    public function index()
    {
        $pacientes = DB::select("CALL Obtener_Pacientes_Cursor(NULL)");
        return view('pacientes.index', ['pacientes' => $pacientes]);
    }

    public function formEliminar()
    {
        return view('eliminar.paciente');
    }

    public function formInsertar()
    {
        return view('insertar.paciente');
    }

    public function insertar(Request $request)
    {
        // Recuperar los datos del formulario
        $nombre = $request->input('Nombre');
        $apellidos = $request->input('Apellidos');
        $telefono = $request->input('Telefono');
        $fechaNacimiento = $request->input('Fecha_nacimiento');
        $ciudad = $request->input('Ciudad');
        $calle = $request->input('Calle');
        $email = $request->input('Email');
        $pin = $request->input('PIN');

        try {
            // Llamada al procedimiento almacenado para insertar el paciente
            DB::statement("CALL Insertar_Paciente(?, ?, ?, ?, ?, ?, ?, ?)", [
                $nombre,
                $apellidos,
                $telefono,
                $fechaNacimiento,
                $ciudad,
                $calle,
                $email,
                bcrypt($pin) // Se utiliza bcrypt para hacer el hash del PIN
            ]);

            // Redirigir con mensaje de éxito
            return redirect()->route('pacientes.insertar.form')->with([
                'mensaje' => 'Paciente registrado correctamente.',
                'tipo' => 'exito'
            ]);
        } catch (\Illuminate\Database\QueryException $ex) {
            // Capturar cualquier excepción de la base de datos
            return redirect()->route('pacientes.insertar.form')->with([
                'mensaje' => 'Error al insertar paciente: ' . $ex->getMessage(),
                'tipo' => 'error'
            ]);
        }
    }

    public function registrar(Request $request)
    {
        $request->validate([
            'Nombre' => 'required|string|max:255',
            'Apellidos' => 'required|string|max:255',
            'Telefono' => 'required|string|max:255',
            'Fecha_nacimiento' => 'required|date',
            'Id_direccion' => 'required|integer',
            'Email' => 'required|string|email|max:255|unique:paciente,Email',
            'PIN' => 'required|string|min:4|max:4'
        ]);

        Paciente::create([
            'Nombre' => $request->Nombre,
            'Apellidos' => $request->Apellidos,
            'Telefono' => $request->Telefono,
            'Fecha_nacimiento' => $request->Fecha_nacimiento,
            'Id_direccion' => $request->Id_direccion,
            'Email' => $request->Email,
            'PIN' => Hash::make($request->PIN)
        ]);

        return redirect('/login')->with('success', 'Paciente registrado correctamente. Inicie sesión.');
    }

    public function eliminar(Request $request)
    {
        $email = $request->input('email_paciente');
        $mensaje = '';
        $tipo = '';

        try {
            $resultado = DB::select("CALL Eliminar_Paciente(?)", [$email]);

            if (isset($resultado[0]->Mensaje)) {
                $mensaje = $resultado[0]->Mensaje;
                $tipo = ($mensaje === 'Paciente eliminado correctamente') ? 'exito' : 'error';
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
