<?php

namespace App\Http\Controllers;

use App\Models\Alumno;
use App\Models\ContratoPlan;
use App\Models\Persona;
use Illuminate\Http\Request;

class AlumnoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $alumnos = Alumno::all();
        return view('alumnos.index',compact('alumnos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($rut)
    {
        $alumno = Alumno::find($rut);
        $contratoVigente = ContratoPlan::where('rut_alumno',$rut)->where('estado',1)->first();
        $contratos = ContratoPlan::where('rut_alumno',$rut)->where('estado',0)->get();
        $asistencias = $contratos->flatMap(function ($contrato) {
            return $contrato->asistencias;
        })->sortByDesc('fecha');
        return view('alumnos.show',compact('alumno','contratoVigente','contratos','asistencias'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($rut)
    {
        $alumno = Alumno::find($rut);
        return view('alumnos.edit',compact('alumno'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $rut)
    {
        $alumno = Alumno::find($rut);
        if ($alumno) {
            $alumno->observaciones = $request->observaciones; 
            $alumno->save();
        }
    
        $persona = Persona::find($rut);
        if ($persona) {
            $persona->update($request->only($persona->getFillable()));
        }
    
        return redirect()->route('alumnos.show', $rut); 
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($rut)
    {
        $alumno = Alumno::findOrFail($rut);

        $referenced = $alumno->contratosPlanes()->exists();
    
        if ($referenced) {
            $alumno->delete();
            return redirect()->route('alumnos.index');
        } else {
            $alumno->forceDelete();
            return redirect()->route('alumnos.index');
        }
    }
}
