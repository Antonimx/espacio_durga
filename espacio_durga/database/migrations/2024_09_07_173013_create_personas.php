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
        Schema::create('personas', function (Blueprint $table) {
            $table->string('rut', 10)->primary();
            $table->string('nombre', 30);
            $table->string('apellido', 30);
            $table->date('fecha_nac');
            $table->string('direccion', 30)->nullable();
            $table->char('genero', 1);
            $table->string('fono', 15);
            $table->boolean('extranjero')->default(0);
            $table->softDeletes();
            //$table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('personas');
    }
};
