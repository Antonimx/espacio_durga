<?php

namespace App\Http\Controllers;

use App\Models\Alumno;
use App\Models\Asistencia;
use App\Models\ContratoPlan;
use App\Models\PlanMensual;
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
        $planes = PlanMensual::where(function ($query) {
            $query->where('estado', 1) 
                  ->orWhereHas('contratosPlanes', function ($subQuery) {
                      $subQuery->where('estado', 1);
                  });
        })
        ->orderBy('n_clases')
        ->get();
    
        $contratos = count(ContratoPlan::where('estado',1)->get());
        $contratosFinalizados = count(ContratoPlan::where('estado', 0)->get());
        //asistencias mensuales
        $asistenciasMensuales = $this->asistenciasController->obtenerAsistenciasMensuales();
        $labels = $asistenciasMensuales['labels'];
        $data = $asistenciasMensuales['data'];
        //perfil de alumno
        $alumnos = count(Alumno::all());
        $generoAlumnos = ContratoPlan::with('alumno.persona')
        ->get()
        ->filter(function ($contrato) {
            return $contrato->alumno && $contrato->alumno->persona;
        })
        ->groupBy(fn($contrato) => $contrato->alumno->persona->genero)
        ->map(function ($contratos) {
            return $contratos->unique(fn($contrato) => $contrato->alumno->persona->rut)->count();
        });

        $edadAlumnos = $this->edadAlumnos();
        $promedioEdad = round(Alumno::with('persona')
        ->get()
        ->filter(fn($alumno) => $alumno->persona)
        ->avg(function ($alumno) {
            return $alumno->persona->edad;
        }));
    
        $totalContratos = ContratoPlan::whereMonth('inicio_mensualidad', Carbon::now()->month)
            ->whereYear('inicio_mensualidad', Carbon::now()->year)
            ->join('planes_mensuales', 'contratos_planes.plan_mensual_id', '=', 'planes_mensuales.id')
            ->sum('planes_mensuales.valor');
        $totalContratos = '$' . number_format($totalContratos, 0, ',', '.');


        $extranjeroCount = Alumno::whereHas('persona', function ($query) {
            $query->where('extranjero', 1)->whereNull('deleted_at');
        })->count();
        $noExtranjeroCount = Alumno::whereHas('persona', function ($query) {
            $query->where('extranjero', 0)->whereNull('deleted_at');
        })->count();
        $totalAlumnos = $extranjeroCount + $noExtranjeroCount;
        $extranjeroPercentage = ($totalAlumnos > 0) ? ($extranjeroCount / $totalAlumnos) * 100 : 0;
        $noExtranjeroPercentage = ($totalAlumnos > 0) ? ($noExtranjeroCount / $totalAlumnos) * 100 : 0;

        return view('home.index', compact('contratos', 'contratosFinalizados', 'labels', 'data', 'generoAlumnos','planes', 'edadAlumnos', 'promedioEdad', 'totalContratos', 'alumnos','extranjeroPercentage', 'noExtranjeroPercentage','extranjeroCount','noExtranjeroCount'));
    }

    public function edadAlumnos()
    {
        $edadAlumnos = ContratoPlan::with('alumno.persona') // Cargar las relaciones necesarias
            ->get()
            ->filter(function ($contrato) {
                return $contrato->alumno && $contrato->alumno->persona;
            })
            ->groupBy(function ($contrato) {
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
            ->map(fn($contratos) => $contratos->unique(fn($contrato) => $contrato->alumno->persona->rut)->count())
            ->filter(fn($count) => $count > 0); // Filtrar intervalos con 0 registros
    
        $orden = [
            'Menores de 18 años' => 0,
            '18-29 años' => 1,
            '30-39 años' => 2,
            '40-49 años' => 3,
            '50+ años' => 4,
        ];
    
        $edadAlumnos = $edadAlumnos->sortBy(function ($count, $key) use ($orden) {
            return $orden[$key] ?? 5; // Si no está en el arreglo $orden, lo coloca al final
        });
    
        return $edadAlumnos;
    }
    
}
