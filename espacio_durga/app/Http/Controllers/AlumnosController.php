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



class AlumnosController extends Controller
{

    protected $personasController;
    protected $contratosController;

    public function __construct()
    {
        $this->personasController = new PersonasController();
        $this->contratosController = new ContratosPlanesController();
    }
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
    public function store(AlumnoRequest $request, PersonaRequest $personaRequest, ContratoPlanRequest $contratoPlanRequest)
    {

        $this->personasController->store($personaRequest);        

        //Si encuentra un alumno borrado lo restora.
        $alumno = Alumno::withTrashed()->where('rut', $request->rut)->first();
        if($alumno){
            $alumno->restore();
        }else{
            $alumno = new Alumno();
            $alumno->fill([
                'rut'=> $request->rut,
                'observaciones'=>$request->observaciones
            ]);
        }
        $alumno->save();

        $this->contratosController->store($contratoPlanRequest,false);

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
    public function update(AlumnoRequest $request, PersonaRequest $personaRequest, $rut)
    {
        $alumno = Alumno::find($rut);
        if ($alumno) {
            $alumno->observaciones = $request->observaciones;
            $alumno->save();
            $this->personasController->update($personaRequest,Persona::find($rut));
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
        $contrato = ContratoPlan::where('rut_alumno',$rut)->where('estado',1)->first();
        if($contrato){
           $contrato = $this->contratosController->finalizarContrato($contrato);
        }

        $alumno->delete();
        if (!$referenced) {
            $persona->delete();
        }

        return redirect()->route('alumnos.index');
    }
}
