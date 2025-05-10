<?php

use Illuminate\Support\Facades\Route;

// Controladores
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\CitaController;
use App\Http\Controllers\PacienteCitaController;
use App\Http\Controllers\DepartamentoController;
use App\Http\Controllers\HospitalController;
use App\Http\Controllers\MedicoController;
use App\Http\Controllers\PacienteController;
use App\Http\Controllers\EnfermedadController;

// Ruta principal
Route::get('/', function () {
    return view('home');
});

// Mostrar el formulario de registro y guradar el paciente
Route::view('/registro', 'registro')->name('registro');
Route::post('/registro', [PacienteController::class, 'registrar'])->name('registro');

// Mostrar la vista de login con rutas de inicio y cierre de sesión
Route::get('/login', [LoginController::class, 'mostrarFormularioLogin'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Rutas para pacientes autenticados
Route::middleware('auth:web')->group(function () {
    Route::view('/menu_paciente', 'menu_paciente')->name('menu_paciente');

    Route::get('/paciente/citas', [PacienteCitaController::class, 'index'])->name('paciente.citas.index');
    Route::get('/paciente/citas/{id}', [PacienteCitaController::class, 'show'])->name('paciente.citas.show');
    Route::get('/paciente/elegir', [PacienteCitaController::class, 'formElegir'])->name('paciente.citas.elegir');
    Route::post('/paciente/procesar-citas', [PacienteCitaController::class, 'procesar'])->name('paciente.citas.procesar');
    Route::post('/paciente/seleccionar', [PacienteCitaController::class, 'seleccionar'])->name('paciente.citas.seleccionar');
    Route::post('/paciente/cancelar', [PacienteCitaController::class, 'cancelar'])->name('paciente.citas.cancelar');
    Route::get('/paciente/citas/{id}/pdf', [PacienteCitaController::class, 'descargarPDF'])->name('paciente.citas.pdf');
});

// Rutas para médicos autenticados
Route::middleware('auth:medico')->group(function () {
    Route::view('/menu_medico', 'menu_medico')->name('menu_medico');

    Route::get('/medico/citas/', [MedicoController::class, 'verCitas'])->name('medico.citas');
    Route::get('/medico/citas/pendientes', [MedicoController::class, 'verCitasPendientes'])->name('medico.citas.pendientes');
    Route::get('/medico/citas/diagnostico/{id}', [MedicoController::class, 'formAñadirDiagnostico'])->name('medico.citas.diagnostico.form');
    Route::post('/medico/citas/diagnostico/{id}', [MedicoController::class, 'procesarDiagnostico'])->name('medico.citas.diagnostico');
});

// Ruta exclusiva para administradores
Route::middleware('auth:web')->group(function () {
    Route::view('/menu_admin', 'menu_admin')->name('menu_admin');

    // Rutas de eliminación de entidades
    Route::get('/eliminar/hospital', [HospitalController::class, 'formEliminar'])->name('hospitales.eliminar.form');
    Route::post('/eliminar/hospital', [HospitalController::class, 'eliminar'])->name('hospitales.eliminar');
    Route::get('/eliminar/medico', [MedicoController::class, 'formEliminar'])->name('medicos.eliminar.form');
    Route::post('/eliminar/medico', [MedicoController::class, 'eliminar'])->name('medicos.eliminar');
    Route::get('/eliminar/paciente', [PacienteController::class, 'formEliminar'])->name('pacientes.eliminar.form');
    Route::post('/eliminar/paciente', [PacienteController::class, 'eliminar'])->name('pacientes.eliminar');
    Route::get('/eliminar/departamento', [DepartamentoController::class, 'formEliminar'])->name('departamentos.eliminar.form');
    Route::post('/eliminar/departamento', [DepartamentoController::class, 'eliminar'])->name('departamentos.eliminar');

    // Rutas de inserción
    Route::get('/insertar/hospital', [HospitalController::class, 'formInsertar'])->name('hospitales.insertar.form');
    Route::post('/insertar/hospital', [HospitalController::class, 'insertar'])->name('hospitales.insertar');
    Route::get('/insertar/medico', [MedicoController::class, 'formInsertar'])->name('medicos.insertar.form');
    Route::post('/insertar/medico', [MedicoController::class, 'insertar'])->name('medicos.insertar');
    Route::get('/insertar/paciente', [PacienteController::class, 'formInsertar'])->name('pacientes.insertar.form');
    Route::post('/insertar/paciente', [PacienteController::class, 'insertar'])->name('pacientes.insertar');
    Route::get('/insertar/departamento', [DepartamentoController::class, 'formInsertar'])->name('departamentos.insertar.form');
    Route::post('/insertar/departamento', [DepartamentoController::class, 'insertar'])->name('departamentos.insertar');

    // Rutas de edición
    Route::get('/editar/hospital/{id}', [HospitalController::class, 'formEditar'])->name('hospitales.editar.form');
    Route::post('/editar/hospital/{id}', [HospitalController::class, 'editar'])->name('hospitales.editar');
    Route::get('/editar/medico/{id}', [MedicoController::class, 'formEditar'])->name('medicos.editar.form');
    Route::post('/editar/medico/{id}', [MedicoController::class, 'editar'])->name('medicos.editar');
    Route::get('/editar/paciente/{id}', [PacienteController::class, 'formEditar'])->name('pacientes.editar.form');
    Route::post('/editar/paciente/{id}', [PacienteController::class, 'editar'])->name('pacientes.editar');
    Route::get('/editar/departamento/{id}', [DepartamentoController::class, 'formEditar'])->name('departamentos.editar.form');
    Route::post('/editar/departamento/{id}', [DepartamentoController::class, 'editar'])->name('departamentos.editar');
});

// Rutas de visualización públicas
Route::get('/hospitales', [HospitalController::class, 'index'])->name('hospitales.index');
Route::get('/medicos', [MedicoController::class, 'index'])->name('medicos.index');
Route::get('/pacientes', [PacienteController::class, 'index'])->name('pacientes.index');
Route::get('/departamentos', [DepartamentoController::class, 'index'])->name('departamentos.index');

// Ruta para mostrar datos de COVID
Route::get('/enfermedades/covid', [EnfermedadController::class, 'mostrarCovid'])->name('enfermedades.covid');
