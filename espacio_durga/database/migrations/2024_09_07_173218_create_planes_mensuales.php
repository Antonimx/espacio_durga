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
        Schema::create('planes_mensuales', function (Blueprint $table) {
            $table->tinyInteger('id')->autoIncrement();
            $table->string('nombre', 20)->unique();
            $table->tinyInteger('n_clases');
            $table->double('valor');
            $table->tinyInteger('cant_contratos_activos')->default(0);
            $table->softDeletes();
            //$table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('planes_mensuales');
    }
};
