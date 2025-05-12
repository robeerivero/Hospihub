<?php

namespace App\Http\Controllers;

use App\Models\Hospital;
use App\Models\Departamento;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class DepartamentoController extends Controller
{
    public function index()
    {
        $departamentos = DB::select("CALL Obtener_Departamentos_Hospitales_Cursor(NULL)");
        return view('departamentos.index', ['departamentos' => $departamentos]);
    }

    public function formEliminar()
    {
        
        $departamentos = DB::table('departamento')
                        ->join('hospital', 'departamento.Id_hospital', '=', 'hospital.Id_hospital')
                        ->select('departamento.Id_departamento', 'departamento.Nombre', 'departamento.Ubicacion', 'hospital.Nombre as NombreHospital')
                        ->get();

        return view('eliminar.departamento', compact('departamentos'));
    }


    public function formInsertar()
    {
        return view('insertar.departamento');
    }

    public function formEditar($id)
    {
        $departamento = DB::select("CALL Obtener_Departamentos_Hospitales_Cursor(?)", [$id]);

        if (!$departamento) {
            return redirect()->route('departamentos.index')->with('error', 'Departamento no encontrado');
        }

        return view('editar.departamento', ['departamento' => $departamento[0]]);
    }

    public function editar(Request $request, $id)
    {
        // Validar los datos del formulario
        $request->validate([
            'nombre_hospital' => 'required|string|max:255',
            'nombre' => 'required|string|max:255',
            'ubicacion' => 'required|string|max:255',
        ]);

        // Recuperar los datos del formulario
        $nombre_hospital = $request->input('nombre_hospital');
        $nombre_departamento = $request->input('nombre');
        $ubicacion = $request->input('ubicacion');

        try {
            // Llamada al procedimiento almacenado para actualizar el departamento
            DB::statement("CALL Editar_Departamento(?, ?, ?, ?)", [$id, $nombre_hospital, $nombre_departamento, $ubicacion]);

            // Redirigir con un mensaje de éxito
            return redirect()->route('departamentos.index')->with([
                'mensaje' => 'Departamento actualizado correctamente.',
                'tipo' => 'exito'
            ]);
        } catch (\Illuminate\Database\QueryException $ex) {
            // Capturar el mensaje de error de la base de datos
            return redirect()->route('departamentos.editar.form', $id)->with([
                'mensaje' => "Error al actualizar el departamento: <br>Hospital no encontrado<br>",
                'tipo' => 'error'
            ]);
        }
    }

/*
DELIMITER $$

CREATE PROCEDURE Insertar_Departamento(
    IN nombre_hospital VARCHAR(50),
    IN nombre VARCHAR(50),
    IN ubicacion VARCHAR(50)
)
BEGIN
    DECLARE v_id_hospital INT;

    DECLARE EXIT HANDLER FOR SQLEXCEPTION
    BEGIN
        ROLLBACK;
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Error al insertar el departamento';
    END;

    START TRANSACTION;

    -- Obtener el ID del hospital
    SELECT Id_hospital INTO v_id_hospital FROM Hospital WHERE Nombre = nombre_hospital;

    -- Verificar si el hospital existe antes de insertar
    IF v_id_hospital IS NULL THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Error: El hospital especificado no existe';
    ELSE
        -- Insertar el departamento
        INSERT INTO Departamento (Id_hospital, Nombre, Ubicacion) 
        VALUES (v_id_hospital, nombre, ubicacion);

        COMMIT;
        SELECT 'Departamento insertado correctamente' AS Mensaje;
    END IF;
END$$

DELIMITER ;
*/

    public function insertar(Request $request)
    {
        $request->validate([
            'nombre_hospital' => 'required|string|max:255',
            'nombre_departamento' => 'required|string|max:255',
            'ubicacion' => 'required|string|max:255',
        ]);

        try {
            // Buscar el ID del hospital antes de la inserción
            $hospital = DB::table('hospital')->where('Nombre', $request->nombre_hospital)->first();

            if (!$hospital) {
                return redirect()->route('departamentos.insertar.form')->with([
                    'mensaje' => 'Error: El hospital especificado no existe.',
                    'tipo' => 'error'
                ]);
            }

            // Insertar el departamento directamente en Laravel
            DB::table('departamento')->insert([
                'Id_hospital' => $hospital->Id_hospital,
                'Nombre' => $request->nombre_departamento,
                'Ubicacion' => $request->ubicacion
            ]);

            return redirect()->route('departamentos.insertar.form')->with([
                'mensaje' => 'Departamento registrado correctamente.',
                'tipo' => 'exito'
            ]);

        } catch (\Exception $e) {
            return redirect()->route('departamentos.insertar.form')->with([
                'mensaje' => 'Error: ' . $e->getMessage(),
                'tipo' => 'error'
            ]);
        }
    }

    public function eliminar(Request $request)
    {
        $request->validate([
            'id_departamento' => 'required|integer|min:1'
        ]);

        try {
            $departamentoExiste = DB::table('departamento')
                                    ->where('Id_departamento', $request->id_departamento)
                                    ->exists();

            if (!$departamentoExiste) {
                return redirect()->route('departamentos.eliminar.form')->with([
                    'mensaje' => 'Error: El departamento especificado no existe.',
                    'tipo' => 'error'
                ]);
            }
            
            $resultado = DB::select("CALL Eliminar_Departamento(?)", [$request->id_departamento]);

            if (!empty($resultado) && isset($resultado[0]->resultado)) {
                $mensaje = $resultado[0]->resultado;
                $tipo = $mensaje === 'Departamento eliminado correctamente' ? 'exito' : 'error';
            } else {
                $mensaje = 'No se recibió respuesta de la función.';
                $tipo = 'error';
            }

        } catch (\Exception $e) {
            $mensaje = 'Error al ejecutar la consulta.';
            $tipo = 'error';
        }

        return redirect()->route('departamentos.eliminar.form')
                         ->with('mensaje', $mensaje)
                         ->with('tipo', $tipo);
    }
}
