<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\PlantillasController;
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
Route::post('/auth', [LoginController::class,'auth'])->name('login.auth');
// correos
Route::get('/aoacall',[PlantillasController::class,'index'])->name('aoacall');
// plantillas
Route::get('plantillas',[PlantillasController::class,'index'])->name('plantillas.index');
