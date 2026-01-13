<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('configuracion_siat', function (Blueprint $table) {
            $table->id();
            
            // Relación con tu tabla empresa existente
            $table->foreignId('empresa_id')->constrained('empresa')->cascadeOnDelete();

            // Datos Extraídos de la Solicitud de Autorización [cite: 10, 11]
            $table->string('nit', 20); // [cite: 10]
            $table->string('razon_social'); // [cite: 10]
            $table->string('codigo_sistema', 100); // [cite: 11]
            $table->string('nombre_sistema'); // [cite: 11]
            
            // Constantes de Ambiente y Modalidad [cite: 12, 14]
            // 1: Producción, 2: Pruebas [cite: 12]
            $table->integer('codigo_ambiente')->default(2); 
            // 1: Electrónica en Línea, 2: Computarizada en Línea [cite: 14]
            $table->integer('codigo_modalidad')->default(1); 

            // Datos de Operación
            $table->integer('codigo_sucursal')->default(0); 
            $table->integer('codigo_punto_venta')->default(0);
            
            // Credenciales Dinámicas (Las que cambiarás en el CRUD)
            $table->string('cuis', 20)->nullable(); // Código Único de Inicio de Sistemas
            $table->text('token_api')->nullable();  // Token de autenticación largo
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('configuracion_siat');
    }
};