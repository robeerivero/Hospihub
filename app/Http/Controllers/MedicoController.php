<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class MedicoController extends Controller
{
    public function index()
    {
        $medicos = DB::select("CALL Obtener_Medicos_Cursor(NULL)");
        return view('medicos.index', ['medicos' => $medicos]);
    }

    public function formEliminar()
    {
        return view('eliminar.medico');
    }

    public function formInsertar()
    {
        return view('insertar.medico');
    }

    public function formEditar($id)
    {
        $medico = DB::select("CALL Obtener_Medicos_Cursor(?)", [$id]);

        if (!$medico) {
            return redirect()->route('medicos.index')->with('error', 'Médico no encontrado');
        }

        return view('editar.medico', ['medico' => $medico[0]]);
    }

    public function editar(Request $request, $id)
    {
        // Validar los datos del formulario
        $request->validate([
            'nombre' => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'telefono' => 'required|string|max:255',
            'fecha_nacimiento' => 'required|date',
            'ciudad' => 'required|string|max:255',
            'calle' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'pin' => 'required|string|min:4|max:4',
            'departamento' => 'required|string|max:255',
            'hospital' => 'required|string|max:255',
        ]);
    
        // Recuperar los datos del formulario
        $nombre = $request->input('nombre');
        $apellidos = $request->input('apellidos');
        $telefono = $request->input('telefono');
        $fecha_nacimiento = $request->input('fecha_nacimiento');
        $ciudad = $request->input('ciudad');
        $calle = $request->input('calle');
        $email = $request->input('email');
        $pin = bcrypt($request->input('pin')); // Hasheo del PIN
        $departamento = $request->input('departamento');
        $hospital = $request->input('hospital');
    
        try {
            // Llamada al procedimiento almacenado para actualizar el médico
            DB::statement("CALL Editar_Medico(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)", [
                $id,
                $nombre,
                $apellidos,
                $telefono,
                $fecha_nacimiento,
                $ciudad,
                $calle,
                $email,
                $pin,
                $departamento,
                $hospital,
            ]);
    
            // Redirigir con un mensaje de éxito
            return redirect()->route('medicos.index')->with([
                'mensaje' => 'Médico actualizado correctamente.',
                'tipo' => 'exito'
            ]);
        } catch (\Illuminate\Database\QueryException $ex) {
            // Capturamos el error de la base de datos
            $mensaje = "Error al actualizar el médico: " . $ex->getMessage();
            return redirect()->route('medicos.editar.form', $id)->with([
                'mensaje' => $mensaje,
                'tipo' => 'error'
            ]);
        } catch (\Exception $e) {
            // Captura cualquier otro tipo de error
            $mensaje = "Error inesperado: " . $e->getMessage();
            return redirect()->route('medicos.editar.form', $id)->with([
                'mensaje' => $mensaje,
                'tipo' => 'error'
            ]);
        }
    }

    public function insertar(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string',
            'apellidos' => 'required|string',
            'telefono' => 'required|string',
            'fecha' => 'required|date',
            'ciudad' => 'required|string',
            'calle' => 'required|string',
            'email' => 'required|email',
            'pin' => 'required|string',
            'hospital' => 'required|string',
            'departamento' => 'required|string',
        ]);

        $mensaje = '';
        $tipo = '';

        try {
            $pinHasheado = bcrypt($request->input('pin'));

            DB::statement("CALL Insertar_Medico(?, ?, ?, ?, ?, ?, ?, ?, ?, ?)", [
                $request->input('hospital'),
                $request->input('departamento'),
                $request->input('nombre'),
                $request->input('apellidos'),
                $request->input('telefono'),
                $request->input('fecha'),
                $request->input('ciudad'),
                $request->input('calle'),
                $request->input('email'),
                $pinHasheado,
            ]);

            $mensaje = 'Médico registrado correctamente.';
            $tipo = 'exito';
        } catch (\Exception $e) {
            $mensaje = 'Error al registrar médico: ' . $e->getMessage();
            $tipo = 'error';
        }

        return redirect()->back()->with(['mensaje' => $mensaje, 'tipo' => $tipo]);
    }

    public function eliminar(Request $request)
    {
        $email = $request->input('email_medico');
        $mensaje = '';
        $tipo = '';

        try {
            $resultado = DB::select("CALL Eliminar_Medico(?)", [$email]);

            if (isset($resultado[0]->Mensaje)) {
                $mensaje = $resultado[0]->Mensaje;
                $tipo = ($mensaje === 'Médico eliminado correctamente') ? 'exito' : 'error';
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

    public function verCitas()
    {
        $citas = DB::select("CALL ObtenerCitasMedico(?)", [Auth::guard('medico')->user()->Id_medico]);
        return view('medicos.citas', compact('citas'));
    }

    public function verCitasPendientes()
    {
        $citasPendientes = DB::select("CALL ObtenerCitasPacienteAsignado(?)", [Auth::guard('medico')->user()->Id_medico]);
        return view('medicos.citas_pendientes', compact('citasPendientes'));
    }

    public function formAñadirDiagnostico($id)
    {
        $cita = DB::select("CALL Obtener_Cita(?)", [$id]);

        if (!$cita) {
            return redirect()->route('medico.citas.todas')->with('error', 'Cita no encontrada.');
        }

        return view('medicos.añadir_diagnostico', compact('cita'));
    }

    public function procesarDiagnostico(Request $request, $id)
    {
        $request->validate([
            'descripcion' => 'required|string|max:1000',
            'recomendacion' => 'nullable|string|max:1000',
            'nombre_medicamento.*' => 'nullable|string|max:255',
            'frecuencia.*' => 'nullable|string|max:255'
        ]);

        try {
            DB::beginTransaction();

            // Verificar si ya existe un diagnóstico para esta cita
            $diagnosticoExistente = DB::select("CALL ObtenerDiagnosticoPorCita(?)", [$id]);
        
            if($diagnosticoExistente) {
                //Eliminar el diagnóstico anterior
                DB::statement("DELETE FROM diagnostico WHERE Id_diagnostico = ?", [$diagnosticoExistente[0]->id_diagnostico]);

                //Actualizar el diagnóstico existente
                DB::statement("UPDATE cita SET Id_diagnostico = NULL WHERE Id_cita = ?", [$id]);
            }

            //Insertar nuevo diagnóstico
            DB::statement("CALL Insertar_Diagnostico(?, ?, ?)", [
                $id,
                $request->input('descripcion'),
                $request->input('recomendacion')
            ]);
            $idDiagnostico = DB::select("SELECT LAST_INSERT_ID() AS id_diagnostico")[0]->id_diagnostico;
            DB::statement("UPDATE cita SET Id_diagnostico = ? WHERE Id_cita = ?", [$idDiagnostico, $id]);

            //Eliminar medicamentos previos si hay modificación
            DB::table('Medicamento')->where('Id_diagnostico', $diagnosticoExistente[0]->Id_diagnostico ?? 0)->delete();

            // Procesar medicamentos
            if ($request->filled('nombre_medicamento')) {
                foreach ($request->input('nombre_medicamento') as $index => $nombre) {
                    DB::table('Medicamento')->insert([
                        'Id_diagnostico' => $idDiagnostico,
                        'Nombre' => $nombre,
                        'Frecuencia' => $request->input('frecuencia')[$index]
                    ]);
                }
            }

            DB::commit();
            return redirect()->route('medico.citas')->with(['mensaje' => '✅ Diagnóstico y medicamentos registrados correctamente.', 'tipo' => 'mensaje-exito']);
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('medico.citas.diagnostico.form', $id)->with(['mensaje' => '❌ Error: ' . $e->getMessage(), 'tipo' => 'mensaje-error']);
        }
    }
}