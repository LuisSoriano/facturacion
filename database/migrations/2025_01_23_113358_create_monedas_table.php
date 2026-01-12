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
        // Schema::create('monedas', function (Blueprint $table) {
        //     $table->id();
        //     $table->string('estandar_iso', 10);
        //     $table->string('nombre_completo');
        //     $table->string('simbolo', 3);
        //     $table->timestamps();

        // });
        Schema::create('monedas', function (Blueprint $table) {
        $table->id();
        // Este es el campo clave para el SIAT
        $table->integer('codigo_clasificador')->unique(); 
        $table->string('nombre_completo');
        // El SIAT no devuelve estos dos, los hacemos opcionales
        $table->string('estandar_iso', 10)->nullable();
        $table->string('simbolo', 10)->nullable(); 
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('monedas');
    }
};
