<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class PacienteController extends Controller
{
    public function index()
    {
        $pacientes = DB::select("CALL Obtener_Pacientes_Cursor(NULL)");
        return view('pacientes.index', ['pacientes' => $pacientes]);
    }
}
