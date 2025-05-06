<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class HospitalController extends Controller
{
    public function index()
    {
        $hospitales = DB::select("CALL Obtener_Hospitales_Cursor(NULL)");
        return view('hospitales.index', ['hospitales' => $hospitales]);
    }
}
