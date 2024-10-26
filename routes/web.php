<?php

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
Auth::routes();
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

//ruta para inscripciones
Route::resource('inscripcions', InscripcionController::class);

//ruta para grados
Route::resource('grados', GradoController::class);

Route::resource('tipopagos', TipopagoController::class);


//ruta para secciones
Route::resource('seccions', SeccionController::class);

//ruta para pagos
Route::resource('pagos', PagoController::class);

//ruta para alumno
Route::resource('registro-alumnos',RegistroAlumnoController::class);

Auth::routes();
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/buscar', [InscripcionController::class, 'buscar'])->name('buscar');
Route::get('/resultados', [InscripcionController::class, 'resultados'])->name('resultados');

Route::get('/buscar', [PagoController::class, 'buscar'])->name('buscar');
Route::get('/resultadosp', [PagoController::class, 'resultadosp'])->name('resultadosp');

