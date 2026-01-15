<?php

namespace Database\Seeders;

use App\Models\Caracteristica;
use App\Models\Categoria;
use App\Models\Cliente;
use App\Models\Documento;
use App\Models\Marca;
use App\Models\Persona;
use App\Models\Presentacione;
use App\Models\Producto;
use App\Models\Proveedore;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class TestDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // ============ MARCAS (4) ============
        $marcasData = [
            'Nike',
            'Adidas',
            'Puma',
            'Reebok'
        ];

        $marcas = [];
        foreach ($marcasData as $nombre) {
            $caracteristica = Caracteristica::firstOrCreate(
                ['nombre' => $nombre],
                ['nombre' => $nombre]
            );
            
            $marca = Marca::firstOrCreate(
                ['caracteristica_id' => $caracteristica->id],
                ['caracteristica_id' => $caracteristica->id]
            );
            $marcas[] = $marca;
        }

        // ============ PRESENTACIONES (10) ============
        $presentacionesData = [
            'Caja',
            'Bolsa',
            'Botella',
            'Lata',
            'Frasco',
            'Paquete',
            'Tubo',
            'Bandeja',
            'Rollo',
            'Sobre'
        ];

        $presentaciones = [];
        foreach ($presentacionesData as $sigla) {
            $caracteristica = Caracteristica::firstOrCreate(
                ['nombre' => $sigla],
                ['nombre' => $sigla]
            );
            
            $presentacion = Presentacione::firstOrCreate(
                ['caracteristica_id' => $caracteristica->id],
                ['caracteristica_id' => $caracteristica->id, 'sigla' => substr($sigla, 0, 3)]
            );
            $presentaciones[] = $presentacion;
        }

        // ============ CATEGORÍAS (5) ============
        $categoriasData = [
            'Electrónica',
            'Ropa y Moda',
            'Alimentos y Bebidas',
            'Hogar y Jardín',
            'Deportes y Recreación'
        ];

        $categorias = [];
        foreach ($categoriasData as $nombre) {
            $caracteristica = Caracteristica::firstOrCreate(
                ['nombre' => $nombre],
                ['nombre' => $nombre]
            );
            
            $categoria = Categoria::firstOrCreate(
                ['caracteristica_id' => $caracteristica->id],
                ['caracteristica_id' => $caracteristica->id]
            );
            $categorias[] = $categoria;
        }

        // ============ PRODUCTOS (100) ============
        $productosNombres = [
            'Laptop HP',
            'Mouse inalámbrico',
            'Teclado mecánico',
            'Monitor LED',
            'Auriculares Bluetooth',
            'Cable USB-C',
            'Adaptador HDMI',
            'Hub USB 3.0',
            'Webcam HD',
            'Micrófono',
            'Lámpara LED',
            'Ventilador',
            'Televisor 55"',
            'Refrigerador',
            'Horno eléctrico',
            'Licuadora',
            'Cafetera',
            'Tostadora',
            'Hervidor eléctrico',
            'Plancha',
            'Camiseta blanca',
            'Pantalón azul',
            'Zapatos deportivos',
            'Calcetines',
            'Cinturón',
            'Gorra',
            'Bufanda',
            'Guantes',
            'Suéter',
            'Falda',
            'Arroz integral',
            'Pasta integral',
            'Aceite de oliva',
            'Sal marina',
            'Azúcar morena',
            'Harina de trigo',
            'Leche',
            'Queso',
            'Yogur',
            'Mantequilla',
            'Pan integral',
            'Cereal',
            'Miel',
            'Mermelada',
            'Café',
            'Té verde',
            'Jugo natural',
            'Agua mineral',
            'Refresco',
            'Cerveza',
            'Pala de jardín',
            'Rastrillo',
            'Manguera',
            'Maceta',
            'Tierra para plantas',
            'Semillas',
            'Fertilizante',
            'Herbicida',
            'Podadera',
            'Guantes de jardinería',
            'Balón de fútbol',
            'Raqueta de tenis',
            'Pelota de ping pong',
            'Red de badminton',
            'Patineta',
            'Bicicleta',
            'Casco',
            'Rodilleras',
            'Muñequeras',
            'Patines',
            'Tabla de surf',
            'Mochila',
            'Bolsa de viaje',
            'Maleta',
            'Cinturón de seguridad',
            'Funda de teléfono',
            'Cargador rápido',
            'Powerbank',
            'Trípode',
            'Lentes de sol',
            'Reloj',
            'Anillo',
            'Pulsera',
            'Collar',
            'Pendientes',
            'Perfume',
            'Desodorante',
            'Jabón de manos',
            'Champú',
            'Acondicionador',
            'Pasta de dientes',
            'Cepillo de dientes',
            'Hilo dental',
            'Cortaúñas',
            'Limador de uñas',
            'Espejo',
            'Peine',
            'Secador de cabello',
            'Alisador',
            'Rizador',
            'Caja de herramientas',
            'Destornillador',
            'Martillo',
            'Llave inglesa',
            'Nivel'
        ];

        $documento = Documento::first();

        $productos = [];
        for ($i = 0; $i < 100; $i++) {
            $nombre = $productosNombres[$i % count($productosNombres)] . ' #' . ($i + 1);
            
            $producto = Producto::firstOrCreate(
                ['codigo' => 'PROD-' . str_pad($i + 1, 4, '0', STR_PAD_LEFT)],
                [
                    'nombre' => $nombre,
                    'codigo' => 'PROD-' . str_pad($i + 1, 4, '0', STR_PAD_LEFT),
                    'categoria_id' => $categorias[$i % count($categorias)]->id,
                    'marca_id' => $marcas[$i % count($marcas)]->id,
                    'presentacione_id' => $presentaciones[$i % count($presentaciones)]->id,
                    'precio' => rand(1500, 75000) / 100,
                    'descripcion' => 'Producto de prueba: ' . $nombre
                ]
            );
            $productos[] = $producto;
        }

        // ============ PROVEEDORES (4) ============
        $proveedoresData = [
            ['nombre' => 'Proveedor TechWorld', 'email' => 'tech@world.com', 'telefono' => '12345678'],
            ['nombre' => 'Distribuidor Global', 'email' => 'global@dist.com', 'telefono' => '87654321'],
            ['nombre' => 'Importadora Premium', 'email' => 'premium@import.com', 'telefono' => '55555555'],
            ['nombre' => 'Mayorista Export', 'email' => 'export@mayor.com', 'telefono' => '99999999']
        ];

        foreach ($proveedoresData as $proveedorData) {
            $numDocumento = 'NIT-' . substr(md5($proveedorData['nombre']), 0, 10);
            
            // Crear persona proveedor
            $persona = Persona::firstOrCreate(
                ['numero_documento' => $numDocumento],
                [
                    'razon_social' => $proveedorData['nombre'],
                    'tipo' => 'JURIDICA',
                    'documento_id' => $documento->id,
                    'numero_documento' => $numDocumento,
                    'direccion' => 'Dirección ' . $proveedorData['nombre'],
                    'email' => $proveedorData['email'],
                    'telefono' => $proveedorData['telefono'],
                    'estado' => 1
                ]
            );

            // Crear proveedor asociado
            Proveedore::firstOrCreate(
                ['persona_id' => $persona->id],
                ['persona_id' => $persona->id]
            );
        }

        // ============ USUARIOS Y ROLES ADICIONALES ============
        // Crear roles adicionales si no existen
        $roleVendedor = Role::firstOrCreate(['name' => 'vendedor']);
        $roleAlmacenero = Role::firstOrCreate(['name' => 'almacenero']);

        // Asignar algunos permisos básicos a estos roles
        $permisosVendedor = ['ver-venta', 'crear-venta', 'ver-cliente', 'crear-cliente'];
        $permisosAlmacenero = ['ver-producto', 'ver-inventario', 'crear-inventario', 'ver-compra'];

        foreach ($permisosVendedor as $permiso) {
            $perm = Permission::where('name', $permiso)->first();
            if ($perm) {
                $roleVendedor->givePermissionTo($perm);
            }
        }

        foreach ($permisosAlmacenero as $permiso) {
            $perm = Permission::where('name', $permiso)->first();
            if ($perm) {
                $roleAlmacenero->givePermissionTo($perm);
            }
        }

        // Crear usuarios de prueba con roles
        $usuariosData = [
            ['nombre' => 'Juan Vendedor', 'email' => 'juan@test.com', 'rol' => 'vendedor'],
            ['nombre' => 'María Almacenera', 'email' => 'maria@test.com', 'rol' => 'almacenero'],
            ['nombre' => 'Carlos Vendedor', 'email' => 'carlos@test.com', 'rol' => 'vendedor'],
        ];

        foreach ($usuariosData as $userData) {
            $user = User::firstOrCreate(
                ['email' => $userData['email']],
                [
                    'name' => $userData['nombre'],
                    'password' => bcrypt('12345678'),
                    'estado' => 1
                ]
            );

            $user->syncRoles([$userData['rol']]);
        }

        echo "\n✓ Datos de prueba creados exitosamente:\n";
        echo "  ✓ 4 Marcas\n";
        echo "  ✓ 10 Presentaciones\n";
        echo "  ✓ 5 Categorías\n";
        echo "  ✓ 100 Productos\n";
        echo "  ✓ 4 Proveedores\n";
        echo "  ✓ 3 Usuarios adicionales (2 vendedores, 1 almacenero)\n";
        echo "  ✓ 2 Roles adicionales (vendedor, almacenero)\n\n";
    }
}
