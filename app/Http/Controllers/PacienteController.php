<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\Paciente;

class PacienteController extends Controller
{
    public function index()
    {
        $pacientes = DB::select("CALL Obtener_Pacientes_Cursor(NULL)");
        return view('pacientes.index', ['pacientes' => $pacientes]);
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
}
