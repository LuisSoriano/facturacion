<?php

namespace Database\Seeders;

use App\Models\Documento;
use Illuminate\Database\Seeder;

class DocumentoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Documento::insert([
            [
                'nombre' => 'CI - CEDULA DE IDENTIDAD',
            ],
            [
                'nombre' => 'CEX - CEDULA DE IDENTIDAD DE EXTRANJERO',
            ],
            [
                'nombre' => 'PAS - PASAPORTE',
            ],
            [
                'nombre' => 'OD - OTRO DOCUMENTO DE IDENTIDAD',
            ],
            [
                'nombre' => 'NIT - NÚMERO DE IDENTIFICACIÓN TRIBUTARIA',
            ],
        ]);
    }
}
