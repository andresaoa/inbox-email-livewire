<?php

use App\Http\Controllers\Controller;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PlantillasController;
use App\Http\Controllers\RolController;
use App\Http\Livewire\CorreoLivewire;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Http;
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

// auth
Route::get('/', [LoginController::class,'login'])->name('login.index');
Route::get('/auth', [LoginController::class,'auth'])->name('login.auth');
// correos
Route::get('/aoacall',[Controller::class,'index'])->name('aoacall');
// plantillas
Route::get('plantillas',[PlantillasController::class,'index'])->name('plantillas.index');
Route::get('plantillas/create',[PlantillasController::class,'create'])->name('plantillas.create');
Route::post('plantilla/store',[PlantillasController::class,'store'])->name('plantillas.store');
Route::get('plantillas/{plantilla}/edit',[PlantillasController::class,'edit'])->name('plantillas.edit');
Route::put('plantillas/{plantilla}',[PlantillasController::class,'update'])->name('plantillas.update');
// rol
Route::get('rol',[RolController::class,'index'])->name('rol.index');
