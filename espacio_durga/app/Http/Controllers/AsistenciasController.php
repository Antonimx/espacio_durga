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
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $alumnos = Alumno::whereHas('contratosPlanes', function ($query) {
            $query->where('estado', 1);
        })->get();
        $contratoPlan = new ContratoPlan();
        return view('asistencia.index', compact('alumnos','contratoPlan'));
    }

    public function gestionar()
    {
        $asistencias = Asistencia::orderBy('fecha_hora','desc')->get();
        return view('asistencia.gestionar', compact('asistencias'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store($rut)
    {
        $alumnos = Alumno::whereHas('contratosPlanes', function ($query) {
            $query->where('estado', 1);
        })->get();
        $contratoPlan = ContratoPlan::where('rut_alumno',$rut)->where('estado',1)->first();
        
        //Validar si ya hay una asistencia en la última hora
        $asistenciaExistente = Asistencia::where('contrato_plan_id', $contratoPlan->id)
        ->whereBetween('fecha_hora', [Carbon::now()->subHour(), Carbon::now()])
        ->first();

        if ($asistenciaExistente) {
            $contratoPlan = new ContratoPlan();
            $horaExistente = Carbon::parse($asistenciaExistente->fecha_hora)->format('H:i');
            return redirect()->route('asistencia.index', compact('alumnos','contratoPlan'))->withErrors(['error' => "Ya se registró una asistencia para este alumno a las $horaExistente. Debe esperar una hora si quiere registrar nuevamente"]);
        }

        
        //Registrar asistencia si no hay errores.
        $asistencia = new Asistencia();
        $asistencia ->fill([
            'contrato_plan_id'=>$contratoPlan->id,
            'rut_alumno'=>$contratoPlan->rut_alumno,
            'fecha_hora'=>Carbon::now()
        ]);
        $asistencia->save();

        //descontar un dia al contrato
        if ($contratoPlan->n_clases_disponibles - 1 == 0){
            $contratoPlan->n_clases_disponibles -= 1;
            $contratoPlan->estado = 0;
        } else {
            $contratoPlan->n_clases_disponibles -= 1;
            $planMensual = PlanMensual::find($contratoPlan->plan_mensual_id);
            $planMensual->update(['cant_contratos_activos' => $planMensual->cant_contratos_activos - 1]);
        }
        $contratoPlan->save();

       
        return view('asistencia.index', compact('alumnos','contratoPlan'));

    }

    
    /**
     * Display the specified resource.
     */
    public function show(Asistencia $asistencia)
    {
        //
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

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $asistencia = Asistencia::find($id);
        $asistencia->delete();
        return redirect()->route('asistencia.gestionar');
    }
}
