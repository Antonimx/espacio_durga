<?php

namespace App\Http\Controllers;

use App\Models\Asistencia;
use App\Models\ContratoPlan;
use Carbon\Carbon;
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
        $contratos = ContratoPlan::where('estado', 1)->get();

        $asistencias = Asistencia::orderBy('fecha_hora', 'asc')->get();;

        // Identificar el rango de meses
        $fechaInicio = $asistencias->min('fecha_hora'); // Fecha más antigua
        $fechaFin = $asistencias->max('fecha_hora');    // Fecha más reciente

        // Crear un rango de meses desde el inicio hasta el final
        $rangoMeses = [];
        $mesActual = Carbon::parse($fechaInicio)->startOfMonth();
        $mesFinal = Carbon::parse($fechaFin)->startOfMonth();

        while ($mesActual <= $mesFinal) {
            $rangoMeses[] = $mesActual->copy();
            $mesActual->addMonth();
        }

        // Inicializar datos
        $labels = [];
        $data = [];

        // Contar asistencias por mes
        $asistenciasPorMes = $asistencias->groupBy(function ($date) {
            return Carbon::parse($date->fecha_hora)->format('Y-m'); // Agrupar por 'Año-Mes'
        });

        // Generar etiquetas y datos asegurando meses vacíos
        foreach ($rangoMeses as $mes) {
            $mesKey = $mes->format('Y-m'); // Llave en formato 'Año-Mes'
            $labels[] = $mes->translatedFormat('F Y'); // Mes en español
            $data[] = isset($asistenciasPorMes[$mesKey]) ? $asistenciasPorMes[$mesKey]->count() : 0; // Asignar 0 si no hay asistencias
        }
        // Pasar los datos a la vista
        return view('home.index', compact('contratos', 'labels', 'data'));
    }
}
