<?php
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AlumnoController;
use App\Http\Controllers\PersonaController;
use App\Http\Controllers\PlanMensualController;
use Illuminate\Support\Facades\Route;


//Home
Route::get('/',[HomeController::class,'index'])->name('home.index');

//Alumnos
Route::resource('/alumnos',AlumnoController::class);

//Personas
Route::resource('/personas',PersonaController::class);

//PlanesMensuales
Route::resource('/planes',PlanMensualController::class);

//Asistencia
Route::resource('/asistencia',PlanMensualController::class);



