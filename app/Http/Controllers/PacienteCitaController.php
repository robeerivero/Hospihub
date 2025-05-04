<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PacienteCitaController extends Controller
{
    public function index()
    {
        $paciente_id = auth()->user()->id;
        $citas = DB::select("CALL Obtener_Citas_Paciente(?)", [$paciente_id]);

        return view('paciente.citas.index', compact('citas'));
    }

    public function show($id)
    {
        $cita = DB::selectOne("
            SELECT c.Fecha, DATE_FORMAT(c.Hora, '%H:%i') AS Hora, m.Nombre AS Nombre_Medico, m.Apellidos AS Apellidos_Medico,
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
        $hospitales = DB::table('Hospital')->get();
        $departamentos = DB::table('Departamento')->get();

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

    public function seleccionar(Request $request)
    {
        $request->validate([
            'cita_id' => 'required|integer',
        ]);

        $paciente_id = auth()->user()->id;

        DB::table('Cita')->where('Id_Cita', $request->cita_id)
            ->update([
                'Id_paciente' => $paciente_id,
                'Estado' => 'Paciente Asignado',
            ]);

        return redirect()->route('paciente.citas.index')->with('success', 'Cita seleccionada correctamente.');
    }

    public function cancelar(Request $request)
    {
        $request->validate([
            'cita_id' => 'required|integer',
        ]);

        DB::table('Cita')->where('Id_Cita', $request->cita_id)
            ->update([
                'Id_paciente' => null,
                'Estado' => 'Disponible',
            ]);

        return redirect()->route('paciente.citas.index')->with('success', 'Cita cancelada.');
    }
}
