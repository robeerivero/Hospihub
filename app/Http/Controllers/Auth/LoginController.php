<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Paciente;
use App\Models\Medico;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function mostrarFormularioLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'Email' => 'required|email',
            'PIN' => 'required|string|min:4',
        ]);

        //Buscar según si es paciente o médico
        $paciente = Paciente::where('Email', $request->Email)->first();
        $medico = Medico::where('Email', $request->Email)->first();

        if($paciente && strtolower($paciente->Nombre) === 'admin') {
            Auth::login($paciente);
            return redirect(route('menu_admin'))->with('success', 'Has iniciado sesión correctamente como admin!!');
        }
        
        if($paciente && Hash::check($request->PIN, $paciente->PIN)) {
            Auth::login($paciente);
            return redirect('/menu_paciente')->with('success', 'Has iniciado sesión correctamente!!');
        }elseif ($medico && Hash::check($request->PIN, $medico->PIN)) {
            Auth::guard('medico')->login($medico);
            session()->put('auth_guard', 'medico'); // 🔥 Guardar el guard activo en la sesión
            session()->regenerate();
            return redirect(route('menu_medico'))->with('success', 'Has iniciado sesión correctamente!!');
        }

        return back()->withErrors(['Email' => 'Las credenciales proporcionadas son incorrectas.',]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        return redirect('/')->with('success', 'Se ha cerrado sesión correctamente.');
    }
}
