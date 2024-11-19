<?php

namespace App\Http\Controllers;

use App\Http\Requests\AsistenciaRequest;
use App\Models\Alumno;
use App\Models\Asistencia;
use App\Models\ContratoPlan;
use App\Models\PlanMensual;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AsistenciasController extends Controller
{
    protected $contratosController;

    public function __construct()
    {
        $this->contratosController = new ContratosPlanesController();
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $asistencias = Asistencia::orderBy('fecha_hora', 'desc')->get();
        return view('asistencia.index', compact('asistencias'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $contratosActivos = ContratoPlan::where('estado', 1)->get();
        $contratoPlan = new ContratoPlan();
        return view('asistencia.create', compact('contratosActivos', 'contratoPlan'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AsistenciaRequest $request, $rut)
    {
        $contratosActivos = ContratoPlan::where('estado', 1)->get();
        $contratoPlan = ContratoPlan::where('rut_alumno', $rut)->where('estado', 1)->first();

        if (!$contratoPlan) {
            $contratoPlan = new ContratoPlan();
            return view('asistencia.index', compact('contratosActivos', 'contratoPlan'));
        }

        $errorAsistencia = $this->errorAsistencia($contratoPlan);
        if ($errorAsistencia) {
            $contratosActivos = ContratoPlan::where('estado', 1)->get();
            return view('asistencia.index', compact('contratosActivos', 'contratoPlan'))->withErrors($errorAsistencia);
        }

        $asistencia = new Asistencia();
        $asistencia->fill([
            'contrato_plan_id' => $contratoPlan->id,
            'rut_alumno' => $contratoPlan->rut_alumno,
            'fecha_hora' => Carbon::now()
        ]);
        $asistencia->save();

        $this->contratosController->descontarNClases($contratoPlan);
        $contratosActivos = ContratoPlan::where('estado', 1)->get();
        return view('asistencia.index', compact('contratosActivos', 'contratoPlan'));
    }

    public function errorAsistencia(ContratoPlan $contratoPlan)
    {
        //validar si hay una asistencia en la ultima hora
        $asistenciaExistente = Asistencia::where('contrato_plan_id', $contratoPlan->id)
            ->whereBetween('fecha_hora', [Carbon::now()->subHour(), Carbon::now()])
            ->first();

        if ($asistenciaExistente) {
            $horaExistente = Carbon::parse($asistenciaExistente->fecha_hora)->format('H:i');
            return 'Ya se registró una asistencia para este alumno a las ' . $horaExistente . ' hrs. Debe esperar una hora si quiere registrar nuevamente';
        }

        //validar si se venció el contrato
        if ($contratoPlan->fin_mensualidad < Carbon::now()) {
            $this->contratosController->finalizarContrato($contratoPlan);
            return 'CONTRATO VENCIDO para el alumno ' . $contratoPlan->alumno->persona->nombre . ' ' . $contratoPlan->alumno->persona->apellido . ' Fin mensualidad: ' . $contratoPlan->fin_mensualidad;
        }

        return false;
    }
    /**
     * Display the specified resource.
     */
    public function show($rut)
    {
        $asistencias = Asistencia::where('rut_alumno',$rut)->orderByDesc('fecha_hora')->get();
        $alumno = Alumno::find($rut);
        return view('asistencia.show',compact('asistencias','alumno'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Asistencia $asistencia)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Asistencia $asistencia)
    {
        //
    }

    public function obtenerAsistenciasMensuales()
    {
        
        $asistencias = Asistencia::orderBy('fecha_hora', 'asc')->get();;

        // Identificar el rango de meses
        $fechaInicio = $asistencias->min('fecha_hora'); // Fecha más antigua
        $fechaFin = $asistencias->max('fecha_hora');    // Fecha más reciente

        // Crear un rango de meses desde el inicio hasta el final
        $rangoMeses = [];
        $mesActual = Carbon::parse($fechaInicio)->startOfMonth();
        $mesFinal = Carbon::parse($fechaFin)->startOfMonth();

        while ($mesActual <= $mesFinal) {
            $rangoMeses[] = $mesActual->copy();
            $mesActual->addMonth();
        }

        // Inicializar datos
        $labels = [];
        $data = [];

        // Contar asistencias por mes
        $asistenciasPorMes = $asistencias->groupBy(function ($date) {
            return Carbon::parse($date->fecha_hora)->format('Y-m'); // Agrupar por 'Año-Mes'
        });

        // Generar etiquetas y datos asegurando meses vacíos
        foreach ($rangoMeses as $mes) {
            $mesKey = $mes->format('Y-m'); // Llave en formato 'Año-Mes'
            $labels[] = $mes->translatedFormat('F Y'); // Mes en español
            $data[] = isset($asistenciasPorMes[$mesKey]) ? $asistenciasPorMes[$mesKey]->count() : 0; // Asignar 0 si no hay asistencias
        }

        return compact('labels','data');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $asistencia = Asistencia::find($id);
        $contratoPlan = ContratoPlan::find($asistencia->contrato_plan_id);
        $contratoPlan->n_clases_disponibles += 1;
        if ($contratoPlan->estado == 0 && $contratoPlan->fin_mensualidad >= Carbon::now()) {
            $contratoPlan->estado = 1;
        }
        $contratoPlan->save();
        $asistencia->delete();
        return redirect()->route('asistencia.gestionar');
    }
}
