<?php

namespace App\Http\Controllers;

use App\Http\Requests\AlumnoRequest;
use App\Http\Requests\ContratoPlanRequest;
use App\Http\Requests\PersonaRequest;
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
    public function store(PersonaRequest $requestPersona, AlumnoRequest $alumnoRequest, ContratoPlanRequest $contratoPlanRequest)
    {
        //PERSONA
        $persona = new Persona();
        $persona->fill([
            'rut'=>$requestPersona->rut,
            'nombre'=>$requestPersona->nombre,
            'apellido'=>$requestPersona->apellido,
            'fecha_nac'=>$requestPersona->fecha_nac,
            'direccion'=>$requestPersona->direccion,
            'fono'=>$requestPersona->fono,
            'extranjero' => $requestPersona->has('extranjero') ? 1 : 0,
        ]);
        $persona->save();
    
        //ALUMNO
        $alumno = new Alumno();
        $alumno->fill([
            'rut'=> $persona->rut,
            'observaciones'=>$alumnoRequest->observaciones
        ]);
        $alumno->save();

        //CONTRATO PLAN
        $contratoPlan = new ContratoPlan();
        $planMensual = PlanMensual::find($contratoPlanRequest->plan_mensual_id);
        $contratoPlan->fill([
            'rut_alumno'=>$alumno->rut,
            'plan_mensual_id'=>$contratoPlanRequest->plan_mensual_id,
            'inicio_mensualidad'=> Carbon::now(),
            'fin_mensualidad'=> Carbon::now()->addDays(31),
            'n_clases_disponibles'=> $planMensual->n_clases
        ]);
        $contratoPlan->save();

        return redirect()->route('alumnos.index');
    }

    public function storePersonaExistente(AlumnoRequest $alumnoRequest, ContratoPlanRequest $contratoPlanRequest)
    {
        $alumno = Alumno::withTrashed()->where('rut', $alumnoRequest->rut)->first();
        if($alumno){
            $alumno->restore();
        }else{
            $alumno = new Alumno();
            $alumno->fill([
                'rut'=> $alumnoRequest->rut,
                'observaciones'=>$alumnoRequest->observaciones
            ]);
        }
        $alumno->save();

        //CONTRATO PLAN
        $contratoPlan = new ContratoPlan();
        $planMensual = PlanMensual::find($contratoPlanRequest->plan_mensual_id);
        $contratoPlan->fill([
            'rut_alumno'=>$alumno->rut,
            'plan_mensual_id'=>$contratoPlanRequest->plan_mensual_id,
            'inicio_mensualidad'=> Carbon::now(),
            'fin_mensualidad'=> Carbon::now()->addDays(31),
            'n_clases_disponibles'=> $planMensual->n_clases
        ]);
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
        $contratos = ContratoPlan::where('rut_alumno',$rut)->where('estado',0)->orderBy('inicio_mensualidad','desc')->get();
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
    public function update(PersonaRequest $personaRequest, AlumnoRequest $alumnoRequest, $rut)
    {
        $alumno = Alumno::find($rut);
        if ($alumno) {
            $alumno->observaciones = $alumnoRequest->observaciones; 
            $alumno->save();
        }
    
        $persona = Persona::find($rut);
        if ($persona) {
            $persona->update($personaRequest->only($persona->fillableOnUpdate()));
        }
    
        return redirect()->route('alumnos.show', $rut); 
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($rut)
    {
        $alumno = Alumno::findOrFail($rut);
        $persona = Persona::findOrFail($rut);
        $referenced = $persona->usuario()->exists(); //verificar si la persona tiene un usuario
        //Terminar contrato si existe uno activo
        ContratoPlan::where('rut_alumno',$rut)->where('estado',1)->update(['estado'=>0]);
        
        $alumno->delete();
        if (!$referenced) {
            $persona->delete();
        } 
        
        return redirect()->route('alumnos.index');
    }
}
