<?php
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AlumnoController;
use App\Http\Controllers\AsistenciaController;
use App\Http\Controllers\PersonaController;
use App\Http\Controllers\PlanMensualController;
use App\Http\Controllers\UsuarioController;
use Illuminate\Support\Facades\Route;


//Home
Route::get('/',[HomeController::class,'index'])->name('home.index');

//Alumnos
Route::get('/alumnos/create/{rut}',[AlumnoController::class,'create'])->name('alumnos.create');
Route::resource('/alumnos',AlumnoController::class,['except'=>['create']]);

//Personas
Route::resource('/personas',PersonaController::class);

//PlanesMensuales
Route::resource('/planes',PlanMensualController::class);

//Asistencia
Route::resource('/asistencia',AsistenciaController::class);

//Usuarios
Route::resource('/usuarios',UsuarioController::class);



