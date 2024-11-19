<?php

namespace App\Http\Controllers;

use App\Models\Alumno;
use App\Models\Asistencia;
use App\Models\ContratoPlan;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    protected $contratosController;
    protected $asistenciasController;

    public function __construct()
    {
        $this->contratosController = new ContratosPlanesController();
        $this->asistenciasController = new AsistenciasController();
    }

    public function index()
    {
        $this->contratosController->validarMensualidades();
        //contratos activos
        $contratos = ContratoPlan::where('estado', 1)->get();
        //asistencias mensuales
        $asistenciasMensuales = $this->asistenciasController->obtenerAsistenciasMensuales();
        $labels = $asistenciasMensuales['labels'];
        $data = $asistenciasMensuales['data'];
        //perfil de alumno
        $generoAlumnos = ContratoPlan::with('alumno')
            ->get()
            ->groupBy(fn($contrato) => $contrato->alumno->persona->genero)
            ->map(function ($contratos) {
                return $contratos->unique(fn($contrato) => $contrato->alumno->persona->rut)->count();
            });

            $edadAlumnos = ContratoPlan::with('alumno')
            ->get()
            ->groupBy(function($contrato) {
                $edad = $contrato->alumno->persona->edad;
        
                if ($edad < 18) {
                    return 'Menores de 18 años';
                } elseif ($edad >= 18 && $edad < 30) {
                    return '18-29 años';
                } elseif ($edad >= 30 && $edad < 40) {
                    return '30-39 años';
                } elseif ($edad >= 40 && $edad < 50) {
                    return '40-49 años';
                } else {
                    return '50+ años';
                }
            })
            ->map(fn($contratos) => $contratos->unique(fn($contrato) => $contrato->alumno->persona->rut)->count());
        


        return view('home.index', compact('contratos', 'labels', 'data', 'generoAlumnos', 'edadAlumnos'));
    }
}
