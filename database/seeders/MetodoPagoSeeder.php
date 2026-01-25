<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MetodoPagoSeeder extends Seeder
{
    public function run(): void
    {
        $metodos = [
            ['codigoClasificador' => 1, 'descripcion' => 'EFECTIVO'],
            ['codigoClasificador' => 2, 'descripcion' => 'TARJETA'],
            ['codigoClasificador' => 3, 'descripcion' => 'CHEQUE'],
            ['codigoClasificador' => 4, 'descripcion' => 'VALES'],
            ['codigoClasificador' => 5, 'descripcion' => 'OTROS'],
            ['codigoClasificador' => 6, 'descripcion' => 'PAGO POSTERIOR'],
            ['codigoClasificador' => 7, 'descripcion' => 'TRANSFERENCIA BANCARIA'],
            ['codigoClasificador' => 8, 'descripcion' => 'DEPOSITO EN CUENTA']
        ];

        foreach ($metodos as $metodo) {
            DB::table('metodo_pago')->updateOrInsert(
                ['codigoClasificador' => $metodo['codigoClasificador']],
                [
                    'descripcion' => $metodo['descripcion'],
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            );
        }
    }
}