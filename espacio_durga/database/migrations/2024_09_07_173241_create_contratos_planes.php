<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('contratos_planes', function (Blueprint $table) {
            $table->id();
            $table->string('rut_alumno', 10);
            $table->tinyInteger('plan_mensual_id');
            $table->date('inicio_mensualidad');
            $table->date('fin_mensualidad');
            $table->tinyInteger('n_clases_disponibles');
            $table->boolean('estado')->default(1);
            $table->softDeletes();
            //FKs
            $table->foreign('rut_alumno')->references('rut')->on('alumnos');
            $table->foreign('plan_mensual_id')->references('id')->on('planes_mensuales');
            //$table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contratos_planes');
    }
};
