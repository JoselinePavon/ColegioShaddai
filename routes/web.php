<?php

use App\Http\Controllers\ContratoController;
use App\Http\Controllers\EncargadoController;
use App\Http\Controllers\GradoController;
use App\Http\Controllers\InscripcionController;
use App\Http\Controllers\PagoController;
use App\Http\Controllers\TipopagoController;
use App\Http\Controllers\RegistroAlumnoController;
use App\Http\Controllers\SeccionController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect()->route('login');
});

// Rutas de autenticación
Auth::routes();

// Grupo de rutas protegidas por el middleware 'auth'
Route::middleware(['auth'])->group(function () {
    // Ruta para home
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    // Rutas para inscripciones
    Route::resource('inscripcions', App\Http\Controllers\InscripcionController::class);
    Route::get('/buscar', [App\Http\Controllers\InscripcionController::class, 'buscar'])->name('buscar');
    Route::get('/resultados', [App\Http\Controllers\InscripcionController::class, 'resultados'])->name('resultados');

    // Rutas para grados
    Route::resource('grados', App\Http\Controllers\GradoController::class);

    // Rutas para tipos de pagos
    Route::resource('tipopagos', App\Http\Controllers\TipopagoController::class);

    // Rutas para secciones
    Route::resource('seccions', App\Http\Controllers\SeccionController::class);

    // Rutas para pagos
    Route::resource('pagos', App\Http\Controllers\PagoController::class);

    Route::get('/buscar', [App\Http\Controllers\PagoController::class, 'buscar'])->name('buscar');
    Route::get('/resultadosp', [App\Http\Controllers\PagoController::class, 'resultadosp'])->name('resultadosp');

    // Rutas para registro de alumnos
    Route::resource('registro-alumnos', App\Http\Controllers\RegistroAlumnoController::class);

    // Rutas para encargados
    Route::resource('encargados', App\Http\Controllers\EncargadoController::class);

    Route::resource('lugars', App\Http\Controllers\LugarController::class);

    Route::resource('colonias', App\Http\Controllers\ColoniaController::class);

    Route::resource('mes', App\Http\Controllers\MeController::class);

    Route::get('/contrato', [ContratoController::class, 'contrato'])->name('contrato');

    Route::get('pagos/{id}', [PagoController::class, 'show'])->name('pagos.show');

    Route::get('/buscar-alumno', [ContratoController::class, 'buscarAlumno'])->name('buscar.alumno');
});
