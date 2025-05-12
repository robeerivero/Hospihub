<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Hospital;
use App\Models\Departamento;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use App\Notifications\CitaReservadaNotification;
use App\Notifications\CitaCanceladaNotification;

class PacienteCitaController extends Controller implements HasMiddleware
{
    // Nuevo uso de HasMiddleware en Laravel 11^
    // El constructor no funciona para versiones posteriores de laravel 11
    public static function middleware(): array
    {
        return [
            new Middleware('auth:web'),
            new Middleware(function ($request, $next) {
                if (!auth()->user() instanceof \App\Models\Paciente) {
                    abort(403, 'Acceso no autorizado.');
                }
                return $next($request);
            }),
        ];
    }

    public function seleccionar(Request $request)
    {
        $request->validate([
            'cita_id' => 'required|integer',
        ]);

        $paciente = auth()->user();

        DB::table('Cita')->where('Id_Cita', $request->cita_id)
            ->update([
                'Id_paciente' => $paciente->Id_paciente,
                'Estado' => 'Paciente Asignado',
            ]);

        // Obtener la cita para enviar datos al correo
        $cita = DB::selectOne("SELECT Fecha, Hora FROM Cita WHERE Id_Cita = ?", [$request->cita_id]);

        $paciente->notify(new CitaReservadaNotification($cita->Fecha, $cita->Hora));

        return redirect()->route('paciente.citas.index')->with('success', 'Cita seleccionada y correo enviado.');
    }

    public function descargarPDF($id)
    {
        $cita = DB::selectOne("
            SELECT c.Id_cita, c.Fecha, DATE_FORMAT(c.Hora, '%H:%i') AS Hora,
                m.Nombre AS Nombre_Medico, m.Apellidos AS Apellidos_Medico,
                d.Nombre AS Departamento, h.Nombre AS Hospital
            FROM Cita c
            JOIN Medico m ON c.Id_medico = m.Id_medico
            JOIN Departamento d ON m.Id_departamento = d.Id_departamento
            JOIN Hospital h ON d.Id_hospital = h.Id_hospital
            WHERE c.Id_cita = ?
        ", [$id]);


        $diagnostico = DB::selectOne("CALL ObtenerDiagnosticoPorCita(?)", [$id]);
        DB::statement("SET @dummy = 0");
        $medicamentos = DB::select("CALL ObtenerMedicamentosPorCita(?)", [$id]);

        $pdf = Pdf::loadView('paciente.citas.pdf', compact('cita', 'diagnostico', 'medicamentos'));
        
        return $pdf->download('cita_detalles.pdf');
    }

    public function index()
    {
        $paciente_id = auth()->user()->Id_paciente; // Usa Id_paciente, no id
        $citas = DB::select("CALL Obtener_Citas_Paciente(?)", [$paciente_id]);

        return view('paciente.citas.index', compact('citas'));
    }

    public function show($id)
    {
        $cita = DB::selectOne("
            SELECT c.Id_cita, c.Fecha, DATE_FORMAT(c.Hora, '%H:%i') AS Hora,
                m.Nombre AS Nombre_Medico, m.Apellidos AS Apellidos_Medico,
                d.Nombre AS Departamento, h.Nombre AS Hospital
            FROM Cita c
            JOIN Medico m ON c.Id_medico = m.Id_medico
            JOIN Departamento d ON m.Id_departamento = d.Id_departamento
            JOIN Hospital h ON d.Id_hospital = h.Id_hospital
            WHERE c.Id_cita = ?
        ", [$id]);

        $diagnostico = DB::selectOne("CALL ObtenerDiagnosticoPorCita(?)", [$id]);
        DB::statement("SET @dummy = 0");
        $medicamentos = DB::select("CALL ObtenerMedicamentosPorCita(?)", [$id]);

        return view('paciente.citas.show', compact('cita', 'diagnostico', 'medicamentos'));
    }

    public function formElegir()
    {
        $hospitales = Hospital::all();
        $departamentos = Departamento::all();

        return view('paciente.citas.elegir', compact('hospitales', 'departamentos'));
    }

    public function procesar(Request $request)
    {
        $request->validate([
            'hospital' => 'required',
            'departamento' => 'required',
            'fecha' => 'required|date',
        ]);

        $citas = DB::select("CALL Obtener_Citas_Pendientes_Cursor(?, ?, ?)", [
            $request->hospital,
            $request->departamento,
            $request->fecha,
        ]);

        return view('paciente.citas.disponibles', [
            'citas' => $citas,
            'hospital' => $request->hospital,
            'departamento' => $request->departamento,
            'fecha' => $request->fecha,
        ]);
    }


    public function cancelar(Request $request)
    {
        $request->validate([
            'cita_id' => 'required|integer',
        ]);

        $cita = DB::selectOne("SELECT Fecha, Hora FROM Cita WHERE Id_cita = ?", [$request->cita_id]);

        DB::table('Cita')->where('Id_cita', $request->cita_id)
            ->update([
                'Id_paciente' => null,
                'Estado' => 'Disponible',
            ]);

        $paciente = auth()->user();
        $paciente->notify(new CitaCanceladaNotification($cita->Fecha, $cita->Hora));

        return redirect()->route('paciente.citas.index')->with('success', 'Cita cancelada y correo enviado.');
    }
}
