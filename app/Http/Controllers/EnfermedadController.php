<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;

class EnfermedadController extends Controller
{
    public function mostrarCovid()
    {
        $response = Http::get('https://disease.sh/v3/covid-19/countries/spain');

        if ($response->successful()) {
            $datos = $response->json();
            return view('enfermedades.covid', compact('datos'));
        } else {
            return response()->json(['error' => 'No se pudo obtener la información.'], 500);
        }
    }
}

