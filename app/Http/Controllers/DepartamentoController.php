<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class DepartamentoController extends Controller
{
    public function index()
    {
        $departamentos = DB::select("CALL Obtener_Departamentos_Hospitales_Cursor(NULL)");
        return view('departamentos.index', ['departamentos' => $departamentos]);
    }
}
