<?php

namespace App\Http\Controllers;

use App\Models\Alumno;
use App\Models\Asistencia;
use App\Models\ContratoPlan;
use App\Models\Persona;
use App\Models\PlanMensual;
use Illuminate\Http\Request;
use Carbon\Carbon;


class AlumnosController extends Controller
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
    public function create($rut)
    {
        $planes = PlanMensual::all();
        if($rut == 'no'){
            $persona = new Persona();
            return view('alumnos.create',compact('persona','planes'));
        } else {
            $persona = Persona::find($rut);
            return view('alumnos.create',compact('persona','planes'));
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $persona = Persona::find($request->rut);
        if ($persona == null){
            $persona = new Persona();
            $persona->fill([
                'rut'=>$request->rut,
                'nombre'=>$request->nombre,
                'apellido'=>$request->apellido,
                'fecha_nac'=>$request->fecha_nac,
                'direccion'=>$request->direccion,
                'fono'=>$request->fono,
                
            ]);
            if ($request->has('extranjero')){
                $persona->extranjero = 1;
            }
            $persona->save();
        }
        $alumno = Alumno::withTrashed()->where('rut', $request->rut)->first();

        if($alumno){
            $alumno->restore();
        }else{
            $alumno = new Alumno();
            $alumno->fill([
                'rut'=>$request->rut,
                'observaciones'=>$request->observaciones
            ]);
        }
        $contratoPlan = new ContratoPlan();
        $planMensual = PlanMensual::find($request->plan_mensual_id);
        $contratoPlan->fill([
            'rut_alumno'=>$request->rut,
            'plan_mensual_id'=>$request->plan_mensual_id,
            'inicio_mensualidad'=> Carbon::now(),
            'fin_mensualidad'=> Carbon::now()->addDays(31),
            'n_clases_disponibles'=> $planMensual->n_clases
        ]);

        $alumno->save();
        $contratoPlan->save();
        return redirect()->route('alumnos.index');
    }

    /**
     * Display the specified resource.
     */
    public function show($rut)
    {
        $alumno = Alumno::find($rut);
        $contratoVigente = ContratoPlan::where('rut_alumno',$rut)->where('estado',1)->first();
        $contratos = ContratoPlan::where('rut_alumno',$rut)->where('estado',0)->get();
        $asistencias = Asistencia::where('rut_alumno',$rut)->orderBy('fecha_hora','desc')->get();
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
