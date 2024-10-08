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
        Schema::create('asistencias', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('contrato_plan_id');
            $table->string('rut_alumno', 10);
            $table->dateTime('fecha_hora');
            $table->foreign('contrato_plan_id')->references('id')->on('contratos_planes');
            $table->foreign('rut_alumno')->references('rut_alumno')->on('contratos_planes');
            //$table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asistencias');
    }
};
