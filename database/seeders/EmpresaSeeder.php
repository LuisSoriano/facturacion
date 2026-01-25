<?php

namespace Database\Seeders;

use App\Models\Empresa;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EmpresaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Empresa::insert([
            'nombre' => 'INSTITUTO NACIONAL DE SALUD OCUPACIONAL',
            'propietario' => 'Lic Armando Ale Quispe',
            'ruc' => '1016503025',
            'porcentaje_impuesto' => '0',
            'abreviatura_impuesto' => 'IVa',
            'direccion' => 'Calle Claudio Sanjinez s/n, Complejo Hospitalario de Miraflores, La Paz - Bolivia',
            'moneda_id' => 1
        ]);
    }
}
