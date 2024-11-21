<?php
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AlumnosController;
use App\Http\Controllers\AsistenciasController;
use App\Http\Controllers\ContratosPlanesController;
use App\Http\Controllers\PersonasController;
use App\Http\Controllers\PlanesMensualesController;
use App\Http\Controllers\UsuariosController;
use App\Http\Requests\ContratoPlanRequest;
use Illuminate\Support\Facades\Route;


//Home
Route::get('/',[HomeController::class,'index'])->name('home.index')->middleware('auth');

//Alumnos
Route::get('/alumnos/create/{rut}',[AlumnosController::class,'create'])->name('alumnos.create')->middleware('auth');
Route::post('/alumnos/store-existente',[AlumnosController::class,'storeExistente'])->name('alumnos.store-existente')->middleware('auth');
Route::resource('/alumnos',AlumnosController::class,['except'=>['create']])->middleware('auth');

//Contratos Planes
Route::resource('/contratos',ContratosPlanesController::class)->middleware('auth');

//Personas
Route::get('/personas/gestion',[PersonasController::class,'gestion'])->name('personas.gestion')->middleware('auth');
Route::resource('/personas',PersonasController::class)->middleware('auth');

//PlanesMensuales
Route::resource('/planes',PlanesMensualesController::class)->middleware('auth');

//Asistencia
Route::post('/asistencia/store/{alumno}',[AsistenciasController::class,'store'])->name('asistencia.store')->middleware('auth');
Route::resource('/asistencia',AsistenciasController::class,['except'=>['store']])->middleware('auth');

//Usuarios
Route::get('/usuarios/login',[UsuariosController::class,'login'])->name('usuarios.login');
Route::post('/usuarios/autenticar',[UsuariosController::class,'autenticar'])->name('usuarios.autenticar');
Route::get('/usuarios/logout',[UsuariosController::class,'logout'])->name('usuarios.logout')->middleware('auth');
Route::get('/usuarios/create/{rut}',[UsuariosController::class,'create'])->name('usuarios.create')->middleware('auth');
Route::post('/usuarios/store-existente',[UsuariosController::class,'storeExistente'])->name('usuarios.store-existente')->middleware('auth');
Route::put('/usuarios/administrar-cuenta/{usuario}',[UsuariosController::class,'administrarCuenta'])->name('usuarios.administrar-cuenta')->middleware('auth');
Route::put('/usuarios/change-passwd/{usuario}',[UsuariosController::class,'changePasswd'])->name('usuarios.change-passwd')->middleware('auth');
Route::get('/usuarios/passwd/{usuario}',[UsuariosController::class,'passwd'])->name('usuarios.passwd')->middleware('auth');

Route::resource('/usuarios',UsuariosController::class,['except'=>['create']])->middleware('auth');



