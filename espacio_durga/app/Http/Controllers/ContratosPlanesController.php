<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContratoPlanRequest;
use App\Models\Alumno;
use App\Models\ContratoPlan;
use App\Models\PlanMensual;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ContratosPlanesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $contratosVigentes = ContratoPlan::with(['alumno' => function($query) {
            $query->withTrashed() // Incluye alumnos eliminados suavemente
                ->with(['persona' => function($query) {
                    $query->withTrashed(); // Incluye personas eliminadas suavemente
                }]);
        }])->where('estado', 1)->orderBy('inicio_mensualidad', 'desc')->get();
        $contratosFinalizados = ContratoPlan::with(['alumno' => function($query) {
            $query->withTrashed() // Incluye alumnos eliminados suavemente
                ->with(['persona' => function($query) {
                    $query->withTrashed(); // Incluye personas eliminadas suavemente
                }]);
        }])->where('estado',0)->orderBy('inicio_mensualidad','desc')->get();
        return view('contratos.index',compact('contratosVigentes','contratosFinalizados'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $alumnos = Alumno::whereDoesntHave('contratosPlanes', function ($query) {
            $query->where('estado', 1);
        })->get();
        $planes = PlanMensual::all();
        return view('contratos.create',compact('alumnos','planes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ContratoPlanRequest $request,$return)
    {
        // dd($request->rut_alumno);
        $contrato = new ContratoPlan();
        $planMensual = PlanMensual::find($request->plan_mensual_id);
        $contrato -> fill([
            'rut_alumno'=> $request->rut,
            'plan_mensual_id'=> $planMensual->id,
            'inicio_mensualidad'=> Carbon::now(),
            'fin_mensualidad'=>Carbon::now()->addDays(31),
            'n_clases_disponibles'=> $planMensual->n_clases,
        ]);
        $contrato->save();
        $planMensual->cant_contratos_activos+=1;
        $planMensual->save();
        if($return){
            return redirect()->route('contratos.create');
        }
    }

    public function finalizarContrato(ContratoPlan $contratoPlan){
        $contratoPlan->estado = 0;
        $planMensual = PlanMensual::find($contratoPlan->plan_mensual_id);
        $planMensual->cant_contratos_activos-=1;
        $planMensual->save();
        $contratoPlan->save();
    }

    public function descontarDia(ContratoPlan $contratoPlan){
        if ($contratoPlan->n_clases_disponibles - 1 == 0){
            $contratoPlan->n_clases_disponibles -= 1;
            $contratoPlan = $this->finalizarContrato($contratoPlan);
        } else {
            $contratoPlan->n_clases_disponibles -= 1;
            $contratoPlan->save();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(ContratoPlan $contratoPlan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ContratoPlan $contratoPlan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ContratoPlan $contratoPlan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ContratoPlan $contratoPlan)
    {
        //
    }
}
