<?php
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});


use App\Http\Controllers\Admin\CitaController;
use App\Http\Controllers\PacienteCitaController;

Route::middleware(['auth', 'paciente'])->group(function () {
    Route::get('/paciente/citas', [PacienteCitaController::class, 'index'])->name('paciente.citas.index');
    Route::get('/paciente/citas/{id}', [PacienteCitaController::class, 'show'])->name('paciente.citas.show');
    Route::get('/paciente/elegir', [PacienteCitaController::class, 'formElegir'])->name('paciente.citas.elegir');
    Route::post('/paciente/procesar-citas', [PacienteCitaController::class, 'procesar'])->name('paciente.citas.procesar');
    Route::post('/paciente/seleccionar', [PacienteCitaController::class, 'seleccionar'])->name('paciente.citas.seleccionar');
    Route::post('/paciente/cancelar', [PacienteCitaController::class, 'cancelar'])->name('paciente.citas.cancelar');
});


Route::prefix('admin')->middleware(['auth', 'admin'])->group(function () {
    Route::get('citas', [CitaController::class, 'index'])->name('admin.citas.index'); // Ver
    Route::post('citas/crear', [CitaController::class, 'crearTodas'])->name('admin.citas.crearTodas'); // Crear todas
    Route::delete('citas/eliminar', [CitaController::class, 'eliminarTodas'])->name('admin.citas.eliminarTodas'); // Eliminar todas
});


Route::get('/hospitales', [HospitalController::class, 'index'])->name('hospitales.index');
use App\Http\Controllers\MedicoController;

Route::get('/medicos', [MedicoController::class, 'index'])->name('medicos.index');
use App\Http\Controllers\PacienteController;

Route::get('/pacientes', [PacienteController::class, 'index'])->name('pacientes.index');

use App\Http\Controllers\DepartamentoController;

Route::get('/departamentos', [DepartamentoController::class, 'index'])->name('departamentos.index');
use App\Http\Controllers\EliminarHospitalController;

Route::get('/eliminar/hospital', [EliminarHospitalController::class, 'form'])->name('hospitales.eliminar.form');
Route::post('/eliminar/hospital', [EliminarHospitalController::class, 'eliminar'])->name('hospitales.eliminar');

use App\Http\Controllers\EliminarMedicoController;

Route::get('/eliminar/medico', [EliminarMedicoController::class, 'form'])->name('medicos.eliminar.form');
Route::post('/eliminar/medico', [EliminarMedicoController::class, 'eliminar'])->name('medicos.eliminar');

use App\Http\Controllers\EliminarPacienteController;

Route::get('/eliminar/paciente', [EliminarPacienteController::class, 'form'])->name('pacientes.eliminar.form');
Route::post('/eliminar/paciente', [EliminarPacienteController::class, 'eliminar'])->name('pacientes.eliminar');

use App\Http\Controllers\EliminarDepartamentoController;

Route::get('/eliminar/departamento', [EliminarDepartamentoController::class, 'form'])->name('departamentos.eliminar.form');
Route::post('/eliminar/departamento', [EliminarDepartamentoController::class, 'eliminar'])->name('departamentos.eliminar');





?>