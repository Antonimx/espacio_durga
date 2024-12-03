<?php

namespace App\Http\Controllers;

use App\Http\Requests\PlanMensualRequest;
use App\Http\Requests\PlanMensualUpdateRequest;
use App\Models\PlanMensual;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class PlanesMensualesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Gate::denies('admin-gestion')) {
            return redirect()->route('home.index');
        }
        $planes = PlanMensual::orderBy('n_clases')->get();
        return view('planes.index', compact('planes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (Gate::denies('admin-gestion')) {
            return redirect()->route('home.index');
        }
        return view('planes.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PlanMensualRequest $request)
    {
        $plan = new PlanMensual();
        $plan->fill([
            'nombre'=> $request->nombre,
            'n_clases'=>$request->n_clases,
            'valor'=>$request->valor
        ]);
        $plan->save();
        return redirect()->route('planes.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(PlanMensual $planMensual)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        if (Gate::denies('admin-gestion')) {
            return redirect()->route('home.index');
        }
        $plan = PlanMensual::find($id);
        return view('planes.edit',compact('plan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PlanMensualUpdateRequest $request, $id)
    {
        $plan = PlanMensual::find($id);
        $plan->nombre = $request->nombre;
        $plan->valor = $request->valor;
        $plan->save();
        return redirect()->route('planes.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $planMensual = PlanMensual::find($id);
        $planMensual->estado = 0;
        $planMensual->save();
        return redirect()->route('planes.index');
    }

    public function reactivar($id){
        $planMensual = PlanMensual::find($id);
        $planMensual->estado = 1;
        $planMensual->save();
        return redirect()->route('planes.index');

    }
}
