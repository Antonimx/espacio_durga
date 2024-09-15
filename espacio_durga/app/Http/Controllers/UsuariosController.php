<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;


class UsuariosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    public function show(Usuario $Usuario)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Usuario $Usuario)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Usuario $Usuario)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Usuario $Usuario)
    {
        //
    }
}
