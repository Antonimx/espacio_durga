<?php

namespace App\Http\Controllers;

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
    public function store(Request $request)
    {
        //
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
    public function update(Request $request, Persona $persona)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Persona $persona)
    {
        //
    }
}
