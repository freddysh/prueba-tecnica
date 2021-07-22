<?php

use App\Http\Controllers\ComunaController;
use App\Http\Controllers\FormularioController;
use App\Http\Controllers\ProvinciaController;
use App\Http\Controllers\RegionesController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SincronizacionController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('sincronizacion/{ruta}', [SincronizacionController::class,'sincronizacion'])->name('sincronizacion');
Route::resource('/', FormularioController::class);
Route::get('api/regiones', [RegionesController::class,'index'])->name('api-regiones');
Route::get('api/provincias/{region_id}', [ProvinciaController::class,'index'])->name('api-provincias');
Route::get('api/comunas/{provinica_id}', [ComunaController::class,'index'])->name('api-comunas');
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
