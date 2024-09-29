<?php
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AlumnosController;
use App\Http\Controllers\AsistenciasController;
use App\Http\Controllers\ContratosPlanesController;
use App\Http\Controllers\PersonasController;
use App\Http\Controllers\PlanesMensualesController;
use App\Http\Controllers\UsuariosController;
use Illuminate\Support\Facades\Route;


//Home
Route::get('/',[HomeController::class,'index'])->name('home.index')->middleware('auth');

//Alumnos
Route::get('/alumnos/create/{rut}',[AlumnosController::class,'create'])->name('alumnos.create')->middleware('auth');
Route::resource('/alumnos',AlumnosController::class,['except'=>['create']])->middleware('auth');

//Contratos Planes
Route::post('/contratos/store/{storeAlumno}',[AlumnosController::class,'store'])->name('contratos.store')->middleware('auth');
Route::resource('/contratos',ContratosPlanesController::class,['except'=>['store']])->middleware('auth');

//Personas
Route::get('/personas/gestion',[PersonasController::class,'gestion'])->name('personas.gestion')->middleware('auth');
Route::resource('/personas',PersonasController::class)->middleware('auth');

//PlanesMensuales
Route::resource('/planes',PlanesMensualesController::class)->middleware('auth');

//Asistencia
Route::get('/asistencia/gestionar',[AsistenciasController::class,'gestionar'])->name('asistencia.gestionar')->middleware('auth');
Route::post('/asistencia/store/{rut}',[AsistenciasController::class,'store'])->name('asistencia.store')->middleware('auth');
Route::resource('/asistencia',AsistenciasController::class,['except'=>['store']])->middleware('auth');

//Usuarios
Route::get('/usuarios/login',[UsuariosController::class,'login'])->name('usuarios.login');
Route::post('/usuarios/autenticar',[UsuariosController::class,'autenticar'])->name('usuarios.autenticar');
Route::get('/usuarios/logout',[UsuariosController::class,'logout'])->name('usuarios.logout')->middleware('auth');

Route::resource('/usuarios',UsuariosController::class)->middleware('auth');



