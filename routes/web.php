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

?>