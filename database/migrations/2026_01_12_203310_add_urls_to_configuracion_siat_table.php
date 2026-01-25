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
        Schema::table('configuracion_siat', function (Blueprint $table) {
            $table->string('url_sincronizacion')->nullable();
            $table->string('url_operaciones')->nullable();
            $table->string('url_codigos')->nullable();
            $table->string('url_facturacion')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('configuracion_siat', function (Blueprint $table) {
            $table->dropColumn(['url_sincronizacion', 'url_operaciones', 'url_codigos', 'url_facturacion']);
        });
    }
};
