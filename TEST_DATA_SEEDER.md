# Seeder de Datos de Prueba

## Descripción

El `TestDataSeeder` crea automáticamente datos de prueba para facilitar el desarrollo y testing de la aplicación.

## Datos Creados

✓ **5 Categorías**
  - Electrónica
  - Ropa y Moda
  - Alimentos y Bebidas
  - Hogar y Jardín
  - Deportes y Recreación

✓ **4 Marcas**
  - Nike
  - Adidas
  - Puma
  - Reebok

✓ **10 Presentaciones**
  - Caja, Bolsa, Botella, Lata, Frasco, Paquete, Tubo, Bandeja, Rollo, Sobre

✓ **100 Productos**
  - Distribuidos entre todas las categorías y marcas
  - Con precios variados (15.00 - 750.00)
  - Códigos únicos: PROD-0001 a PROD-0100

✓ **4 Proveedores**
  - Proveedor TechWorld
  - Distribuidor Global
  - Importadora Premium
  - Mayorista Export

✓ **4 Usuarios**
  - Sak Noel (admin@admin.com) - Rol: administrador
  - Juan Vendedor (juan@test.com) - Rol: vendedor
  - María Almacenera (maria@test.com) - Rol: almacenero
  - Carlos Vendedor (carlos@test.com) - Rol: vendedor

✓ **3 Roles**
  - administrador (61 permisos)
  - vendedor (4 permisos)
  - almacenero (4 permisos)

## Cómo Usar

### Ejecutar el seeder de pruebas

```bash
php artisan db:seed --class=TestDataSeeder
```

### Ejecutar todos los seeders (incluido TestDataSeeder)

```bash
php artisan db:seed
```

### Limpiar la base de datos e insertar todos los datos nuevamente

```bash
php artisan migrate:fresh --seed
```

## Credentials de Prueba

| Usuario | Email | Contraseña | Rol |
|---------|-------|-----------|-----|
| Sak Noel | admin@admin.com | 12345678 | administrador |
| Juan Vendedor | juan@test.com | 12345678 | vendedor |
| María Almacenera | maria@test.com | 12345678 | almacenero |
| Carlos Vendedor | carlos@test.com | 12345678 | vendedor |

## Modificar el Seeder

El archivo está ubicado en:
```
database/seeders/TestDataSeeder.php
```

Para agregar más datos o modificar los existentes, edita el seeder y ejecuta:

```bash
php artisan migrate:fresh --seed
```

## Notas

- Los datos se crean con `firstOrCreate()`, por lo que es seguro ejecutar el seeder múltiples veces sin crear duplicados.
- El seeder se ejecuta automáticamente cuando usas `php artisan migrate:fresh --seed`.
- Los proveedores se crean como personas jurídicas con documentos de tipo "JURIDICA".
- Las categorías, marcas y presentaciones están vinculadas a características.
