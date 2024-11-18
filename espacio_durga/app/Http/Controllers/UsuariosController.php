<?php

namespace App\Http\Controllers;

use App\Http\Requests\PersonaRequest;
use App\Http\Requests\PersonaUpdateRequest;
use App\Http\Requests\UsuarioAdministrarCuentaRequest;
use App\Http\Requests\UsuarioRequest;
use App\Http\Requests\UsuarioUpdateRequest;
use App\Models\Persona;
use App\Models\Rol;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;


class UsuariosController extends Controller
{
    protected $personasController;
    public function __construct()
    {
        $this->personasController = new PersonasController();
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if(Gate::denies('admin-gestion'))
        {
            return redirect()->route('home.index');
        }
        $usuarios = Usuario::orderBy('nivel_acceso')->get();
        return view('usuarios.index',compact('usuarios'));
    }

    public function login()
    {
        return view('usuarios.login');
    }
    
    public function logout()
    {
        Auth::logout();
        return redirect()->route('usuarios.login');
    }
    public function autenticar(Request $request)
    {
        $credenciales = $request->only(['rut','password']);

        if(Auth::attempt($credenciales))
        {
            //credenciales correctas
            $request->session()->regenerate();
            return redirect()->route('home.index');

        }
        return back()->withErrors('Credenciales incorrectas.')->onlyInput('rut');
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create($rut)
    {
        if(Gate::denies('admin-gestion'))
        {
            return redirect()->route('home.index');
        }
        $roles = Rol::all();
        if($rut == 'no'){
            $persona = new Persona();
            return view('usuarios.create',compact('persona','roles'));
        } else {
            $persona = Persona::find($rut);
            return view('usuarios.create',compact('persona','roles'));
        }    
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PersonaRequest $personaRequest, UsuarioRequest $request)
    {
        if(Gate::denies('admin-gestion'))
        {
            return redirect()->route('home.index');
        }
        $this->personasController->store($personaRequest);               
        $usuario = new Usuario();
        $usuario->fill([
            'rut'=> $request->rut,
            'nivel_acceso'=> $request->nivel_acceso,
            'password' => Hash::make($request->password)
        ]);
        $usuario->save();
        return redirect()->route('usuarios.index');
    }
    
    public function storeExistente(UsuarioRequest $request)
    {
        if(Gate::denies('admin-gestion'))
        {
            return redirect()->route('home.index');
        }
        $usuario = new Usuario();
        $usuario->fill([
            'rut'=> $request->rut,
            'nivel_acceso'=> $request->nivel_acceso,
            'password' => Hash::make($request->password)

        ]);
        $usuario->save();
        return redirect()->route('usuarios.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Usuario $usuario)
    {
        return view('usuarios.show',compact('usuario'));
    }

    public function administrarCuenta(Usuario $usuario, PersonaUpdateRequest $request)
    {
       if ($usuario){
        if ($request->password){
            $usuario->password = Hash::make($request->password);
            $usuario->save();
        }
        $this->personasController->update($request,Persona::find($usuario->rut));
       }
       return redirect()->route('usuarios.show',['usuario'=>$usuario->rut])->with('success', 'Datos actualizados exitosamente.');
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Usuario $usuario)
    {

        $roles = Rol::all();
        if(Gate::denies('admin-gestion'))
        {
            return redirect()->route('home.index');
        }
        return view('usuarios.edit',compact('usuario','roles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UsuarioUpdateRequest $request, PersonaUpdateRequest $personaRequest, Usuario $usuario)
    {
        if ($usuario) {
            $usuario->nivel_acceso = $request->nivel_acceso;
            $usuario->save();
            $this->personasController->update($personaRequest, Persona::find($usuario->rut));
        }
        return redirect()->route('usuarios.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($rut)
    {
        if(Gate::denies('admin-gestion'))
        {
            return redirect()->route('home.index');
        }
        $usuario = Usuario::find($rut);
        $persona = Persona::findOrFail($rut);
        $referenced = $persona->alumno()->exists(); //verificar si la persona tiene un alumno

        if(Auth::user()->rut == $usuario->rut){
            return redirect()->route('usuarios.index')->withErrors('No puede eliminar su propia cuenta');
        }
        $usuario->delete();
        if (!$referenced) {
            $persona->delete();
        }
        

        return redirect()->route('usuarios.index');
    }
}
