<?php

use Illuminate\Support\Facades\Route;

// Controladores generales
use App\Http\Controllers\Admin\CitaController;
use App\Http\Controllers\PacienteCitaController;
use App\Http\Controllers\HospitalController;
use App\Http\Controllers\MedicoController;
use App\Http\Controllers\PacienteController;
use App\Http\Controllers\DepartamentoController;

// Controladores de eliminación
use App\Http\Controllers\EliminarHospitalController;
use App\Http\Controllers\EliminarMedicoController;
use App\Http\Controllers\EliminarPacienteController;
use App\Http\Controllers\EliminarDepartamentoController;

// Ruta principal
Route::get('/', function () {
    return view('home');
});

// Rutas para pacientes autenticados
Route::middleware(['auth', 'paciente'])->group(function () {
    Route::get('/paciente/citas', [PacienteCitaController::class, 'index'])->name('paciente.citas.index');
    Route::get('/paciente/citas/{id}', [PacienteCitaController::class, 'show'])->name('paciente.citas.show');
    Route::get('/paciente/elegir', [PacienteCitaController::class, 'formElegir'])->name('paciente.citas.elegir');
    Route::post('/paciente/procesar-citas', [PacienteCitaController::class, 'procesar'])->name('paciente.citas.procesar');
    Route::post('/paciente/seleccionar', [PacienteCitaController::class, 'seleccionar'])->name('paciente.citas.seleccionar');
    Route::post('/paciente/cancelar', [PacienteCitaController::class, 'cancelar'])->name('paciente.citas.cancelar');
});

// Rutas para administradores autenticados
Route::prefix('admin')->middleware(['auth', 'admin'])->group(function () {
    Route::get('citas', [CitaController::class, 'index'])->name('admin.citas.index');
    Route::post('citas/crear', [CitaController::class, 'crearTodas'])->name('admin.citas.crearTodas');
    Route::delete('citas/eliminar', [CitaController::class, 'eliminarTodas'])->name('admin.citas.eliminarTodas');
});

// Rutas de visualización
Route::get('/hospitales', [HospitalController::class, 'index'])->name('hospitales.index');
Route::get('/medicos', [MedicoController::class, 'index'])->name('medicos.index');
Route::get('/pacientes', [PacienteController::class, 'index'])->name('pacientes.index');
Route::get('/departamentos', [DepartamentoController::class, 'index'])->name('departamentos.index');

// Rutas para eliminar entidades
Route::get('/eliminar/hospital', [EliminarHospitalController::class, 'form'])->name('hospitales.eliminar.form');
Route::post('/eliminar/hospital', [EliminarHospitalController::class, 'eliminar'])->name('hospitales.eliminar');

Route::get('/eliminar/medico', [EliminarMedicoController::class, 'form'])->name('medicos.eliminar.form');
Route::post('/eliminar/medico', [EliminarMedicoController::class, 'eliminar'])->name('medicos.eliminar');

Route::get('/eliminar/paciente', [EliminarPacienteController::class, 'form'])->name('pacientes.eliminar.form');
Route::post('/eliminar/paciente', [EliminarPacienteController::class, 'eliminar'])->name('pacientes.eliminar');

Route::get('/eliminar/departamento', [EliminarDepartamentoController::class, 'form'])->name('departamentos.eliminar.form');
Route::post('/eliminar/departamento', [EliminarDepartamentoController::class, 'eliminar'])->name('departamentos.eliminar');
