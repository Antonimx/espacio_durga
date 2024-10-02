<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    protected $contratosController;

    public function __construct()
    {
        $this->contratosController = new ContratosPlanesController();
    }
    public function index()
    {
        $this->contratosController->validarMensualidades();
        return view('home.index');
    }
}
