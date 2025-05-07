<?php

use Illuminate\Support\Facades\Route;

// Controladores generales
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\CitaController;
use App\Http\Controllers\PacienteCitaController;
use App\Http\Controllers\DepartamentoController;
use App\Http\Controllers\HospitalController;
use App\Http\Controllers\MedicoController;
use App\Http\Controllers\PacienteController;
use App\Http\Controllers\EnfermedadController; // ✅ MOVIDO AQUÍ ARRIBA


// Ruta principal
Route::get('/', function () {
    return view('home');
});

//Mostrar la vista de registro
Route::view('/registro', 'registro')->name('registro');
//Guardar el registro de un paciente
Route::post('/registro', [PacienteController::class, 'registrar'])->name('registro');

//Mostrar la vista de login
Route::get('/login', [LoginController::class, 'mostrarFormularioLogin'])->name('login');
//Iniciar sesión
Route::post('/login', [LoginController::class, 'login'])->name('login');
//Cerrar sesión
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Rutas para pacientes autenticados
Route::middleware(['auth', 'paciente'])->group(function () {
    //Mostrar la vista del menú del paciente
    Route::view('menu_paciente', 'menu_paciente')->name('menu_paciente');
    Route::get('/paciente/citas', [PacienteCitaController::class, 'index'])->name('paciente.citas.index');
    Route::get('/paciente/citas/{id}', [PacienteCitaController::class, 'show'])->name('paciente.citas.show');
    Route::get('/paciente/elegir', [PacienteCitaController::class, 'formElegir'])->name('paciente.citas.elegir');
    Route::post('/paciente/procesar-citas', [PacienteCitaController::class, 'procesar'])->name('paciente.citas.procesar');
    Route::post('/paciente/seleccionar', [PacienteCitaController::class, 'seleccionar'])->name('paciente.citas.seleccionar');
    Route::post('/paciente/cancelar', [PacienteCitaController::class, 'cancelar'])->name('paciente.citas.cancelar');
});

//Rutas para médicos autenticados
Route::middleware(['auth', 'medico'])->group(function () {
    //Mostrar la vista del menú del médico
    Route::view('/menu_medico', 'menu_medico')->name('menu_medico');
    //  **POR HACER RESTO DE FUNCIONES**
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
Route::get('/eliminar/hospital', [HospitalController::class, 'form'])->name('hospitales.eliminar.form');
Route::post('/eliminar/hospital', [HospitalController::class, 'eliminar'])->name('hospitales.eliminar');

Route::get('/eliminar/medico', [MedicoController::class, 'form'])->name('medicos.eliminar.form');
Route::post('/eliminar/medico', [MedicoController::class, 'eliminar'])->name('medicos.eliminar');

Route::get('/eliminar/paciente', [PacienteController::class, 'form'])->name('pacientes.eliminar.form');
Route::post('/eliminar/paciente', [PacienteController::class, 'eliminar'])->name('pacientes.eliminar');

Route::get('/eliminar/departamento', [DepartamentoController::class, 'formEliminar'])->name('departamentos.eliminar.form');
Route::post('/eliminar/departamento', [DepartamentoController::class, 'eliminar'])->name('departamentos.eliminar');

//Rutas de inserción
Route::get('/insertar/hospital', [HospitalController::class, 'formInsertar'])->name('hospitales.insertar.form');
Route::post('/insertar/hospital', [HospitalController::class, 'insertar'])->name('hospitales.insertar');

Route::get('/insertar/medico', [MedicoController::class, 'formInsertar'])->name('medicos.insertar.form');
Route::post('/insertar/medico', [MedicoController::class, 'insertar'])->name('medicos.insertar');

Route::get('/insertar/departamento', [DepartamentoController::class, 'formInsertar'])->name('departamentos.insertar.form');
Route::post('/insertar/departamento', [DepartamentoController::class, 'insertar'])->name('departamentos.insertar');


// Ruta para mostrar datos COVID desde la API
Route::get('/enfermedades/covid', [EnfermedadController::class, 'mostrarCovid'])->name('enfermedades.covid');
