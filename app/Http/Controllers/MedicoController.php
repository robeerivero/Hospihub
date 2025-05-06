<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class MedicoController extends Controller
{
    public function index()
    {
        $medicos = DB::select("CALL Obtener_Medicos_Cursor(NULL)");
        return view('medicos.index', ['medicos' => $medicos]);
    }
}

