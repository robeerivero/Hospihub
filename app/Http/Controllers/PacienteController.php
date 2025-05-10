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

    public function formEditar($id)
    {
        // Obtener los datos del paciente usando su ID
        $paciente = DB::select("CALL Obtener_Pacientes_Cursor(?)", [$id]);

        // Si el paciente no existe, redirigir con mensaje de error
        if (!$paciente) {
            return redirect()->route('pacientes.index')->with('error', 'Paciente no encontrado');
        }

        // Pasar los datos a la vista
        return view('editar.paciente', ['paciente' => $paciente[0]]);
    }

    public function editar(Request $request, $id)
    {
        // Validar los datos del formulario
        $request->validate([
            'Nombre' => 'required|string|max:255',
            'Apellidos' => 'required|string|max:255',
            'Telefono' => 'required|string|max:255',
            'Fecha_nacimiento' => 'required|date',
            'Ciudad' => 'required|string|max:255',
            'Calle' => 'required|string|max:255',
            'Email' => 'required|string|email|max:255',
            'PIN' => 'required|string|min:4|max:4'
        ]);

        // Obtener los datos del formulario
        $nombre = $request->input('Nombre');
        $apellidos = $request->input('Apellidos');
        $telefono = $request->input('Telefono');
        $fechaNacimiento = $request->input('Fecha_nacimiento');
        $ciudad = $request->input('Ciudad');
        $calle = $request->input('Calle');
        $email = $request->input('Email');
        $pin = bcrypt($request->input('PIN')); // Hashear el PIN

        try {
            // Intentar con Eloquent para actualizar los datos
            $paciente = Paciente::findOrFail($id);
            $paciente->Nombre = $nombre;
            $paciente->Apellidos = $apellidos;
            $paciente->Telefono = $telefono;
            $paciente->Fecha_nacimiento = $fechaNacimiento;
            $paciente->Ciudad = $ciudad;
            $paciente->Calle = $calle;
            $paciente->Email = $email;
            $paciente->PIN = $pin;

            $paciente->save(); // Guardar los cambios

            return redirect()->route('pacientes.index')->with([
                'mensaje' => 'Paciente actualizado correctamente.',
                'tipo' => 'exito'
            ]);
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->route('pacientes.editar.form', $id)->with([
                'mensaje' => 'Error al actualizar el paciente: ' . $e->getMessage(),
                'tipo' => 'error'
            ]);
        }
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
