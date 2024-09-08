<?php

namespace App\Http\Controllers;

use App\Models\PlanMensual;
use Illuminate\Http\Request;

class PlanMensualController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('planes.index');
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
    public function show(PlanMensual $planMensual)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PlanMensual $planMensual)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PlanMensual $planMensual)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PlanMensual $planMensual)
    {
        //
    }
}
