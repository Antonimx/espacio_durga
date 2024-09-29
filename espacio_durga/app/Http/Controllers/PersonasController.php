<?php

namespace App\Http\Controllers;

use App\Http\Requests\PersonaRequest;
use App\Models\Alumno;
use App\Models\Persona;
use App\Models\Usuario;
use Illuminate\Http\Request;

class PersonasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $nombreRuta = $request->query('from', 'default_route');
        if ( $nombreRuta == 'alumnos'){
            $alumnos = Alumno::pluck('rut');
            $personas = Persona::whereNotIn('rut',$alumnos)->get();

        } 
        elseif ($nombreRuta == 'usuarios'){
            $usuarios = Usuario::pluck('rut');
            $personas = Persona::whereNotIn('rut',$usuarios)->get();

        }
        else{
            $personas = Persona::all();
        }
        return view('personas.index',compact('personas','nombreRuta'));
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
    public function store(PersonaRequest $request)
    {
        $persona = Persona::find($request->rut);
        //Crea una persona nueva solo si ya no existe, duh
        if (!$persona){
            $persona = new Persona();
            $persona->fill([
                'rut'=>$request->rut,
                'nombre'=>$request->nombre,
                'apellido'=>$request->apellido,
                'fecha_nac'=>$request->fecha_nac,
                'direccion'=>$request->direccion,
                'fono'=>$request->fono,
                'extranjero' => $request->has('extranjero') ? 1 : 0,
            ]);
            $persona->save();
        }

    }

    /**
     * Display the specified resource.
     */
    public function show(Persona $persona)
    {

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Persona $persona)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PersonaRequest $request, Persona $persona)
    {
        $persona->update($request->only($persona->fillableOnUpdate()));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Persona $persona)
    {
        //
    }
}
