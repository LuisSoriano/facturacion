# Sistema de Cálculo de Precios en Productos

## 📊 Arquitectura del Sistema

El sistema de precios en esta aplicación está **DESACOPLADO** del producto. Los precios se manejan en tres contextos diferentes:

### 1. **TABLA: productos**
- Campo: `precio` (decimal 8,2)
- **Propósito**: Almacenar el precio GENÉRICO del producto
- **Uso**: Referencia informativa (actualmente NO se usa en compras/ventas)

### 2. **TABLA: compras (relación Many-to-Many)**
- Tabla pivot: `compra_producto`
- Campos relevantes:
  - `precio_compra`: El precio de compra específico de esa transacción
  - `cantidad`: Cantidad comprada
  - `fecha_vencimiento`: Fecha de vencimiento del lote

```
Flujo de Compra:
┌─────────────────────────────────────────┐
│    Usuario crear compra                 │
│  (ruta: /admin/compras/create)          │
└────────────────┬────────────────────────┘
                 │
                 ▼
┌─────────────────────────────────────────┐
│  Selecciona producto + cantidad         │
│  INGRESA precio_compra específico       │
│  (NO usa el precio genérico)            │
└────────────────┬────────────────────────┘
                 │
                 ▼
┌─────────────────────────────────────────┐
│  Se guarda en compra_producto pivot     │
│  - precio_compra: valor ingresado       │
│  - cantidad: cantidad ingresada         │
│  - fecha_vencimiento: opcional          │
└────────────────┬────────────────────────┘
                 │
                 ▼
┌─────────────────────────────────────────┐
│  Se dispara evento: CompraCreada        │
│  Actualiza Inventario automáticamente   │
└─────────────────────────────────────────┘
```

### 3. **TABLA: ventas (relación Many-to-Many)**
- Tabla pivot: `producto_venta`
- Campos relevantes:
  - `precio_venta`: El precio de venta específico de esa transacción
  - `cantidad`: Cantidad vendida

```
Flujo de Venta:
┌─────────────────────────────────────────┐
│    Usuario crear venta                  │
│  (ruta: /admin/ventas/create)           │
└────────────────┬────────────────────────┘
                 │
                 ▼
┌─────────────────────────────────────────┐
│  Selecciona producto + cantidad         │
│  INGRESA precio_venta específico        │
│  (NO usa el precio genérico)            │
└────────────────┬────────────────────────┘
                 │
                 ▼
┌─────────────────────────────────────────┐
│  Se guarda en producto_venta pivot      │
│  - precio_venta: valor ingresado        │
│  - cantidad: cantidad ingresada         │
└────────────────┬────────────────────────┘
                 │
                 ▼
┌─────────────────────────────────────────┐
│  Se dispara evento: VentaCreada         │
│  Actualiza Inventario automáticamente   │
└─────────────────────────────────────────┘
```

## 🔄 Flujo Completo: Creación de Producto

### Paso 1: Vista de Creación
```
/recursos/views/producto/create.blade.php
├─ nombre: TextField
├─ descripcion: TextArea
├─ img_path: FileInput (opcional)
├─ codigo: TextField (auto-generado si está vacío)
├─ marca_id: Select
├─ presentacione_id: Select (requerido)
└─ categoria_id: Select
```

**NOTA**: ❌ NO hay campo de precio en la vista de creación

### Paso 2: Validación (Request)
```php
// app/Http/Requests/StoreProductoRequest.php
'codigo' => 'nullable|unique:productos,codigo|max:50',
'nombre' => 'required|unique:productos,nombre|max:255',
'descripcion' => 'nullable|max:255',
'img_path' => 'nullable|image|mimes:png,jpg,jpeg|max:2048',
'marca_id' => 'nullable|integer|exists:marcas,id',
'presentacione_id' => 'required|integer|exists:presentaciones,id',
'categoria_id' => 'nullable|integer|exists:categorias,id'
```

**NOTA**: ❌ NO hay validación de precio

### Paso 3: Creación (Controlador)
```php
// app/Http/Controllers/ProductoController.php
public function store(StoreProductoRequest $request): RedirectResponse
{
    $this->productoService->crearProducto($request->validated());
    // ...
}
```

### Paso 4: Creación (Servicio)
```php
// app/Services/ProductoService.php
public function crearProducto(array $data): Producto
{
    $producto = Producto::create([
        'codigo' => $data['codigo'],
        'nombre' => $data['nombre'],
        'descripcion' => $data['descripcion'],
        'img_path' => isset($data['img_path']) && $data['img_path']
            ? $this->handleUploadImage($data['img_path'])
            : null,
        'marca_id' => $data['marca_id'],
        'categoria_id' => $data['categoria_id'],
        'presentacione_id' => $data['presentacione_id'],
    ]);
    
    return $producto;
}
```

**RESULTADO**: El producto se crea CON PRECIO = NULL (no se establece)

### Paso 5: Boot del Modelo
```php
// app/Models/Producto.php
protected static function booted()
{
    static::creating(function ($producto) {
        // Si no se proporciona un código, generar uno único
        if (empty($producto->codigo)) {
            $producto->codigo = self::generateUniqueCode();
        }
    });
}
```

## 💰 ¿Dónde se establece el precio?

El precio se establece en **dos momentos específicos**:

### 1️⃣ **DURANTE LA COMPRA**
- Usuario crea una compra
- Selecciona un producto
- **INGRESA `precio_compra`** manualmente
- Se guarda en tabla pivot `compra_producto`

### 2️⃣ **DURANTE LA VENTA**
- Usuario crea una venta
- Selecciona un producto
- **INGRESA `precio_venta`** manualmente
- Se guarda en tabla pivot `producto_venta`

## 📁 Archivos Relevantes

| Archivo | Función |
|---------|---------|
| [app/Models/Producto.php](app/Models/Producto.php) | Modelo base del producto |
| [app/Http/Controllers/ProductoController.php](app/Http/Controllers/ProductoController.php) | Control de producto |
| [app/Services/ProductoService.php](app/Services/ProductoService.php) | Lógica de creación/edición |
| [app/Http/Requests/StoreProductoRequest.php](app/Http/Requests/StoreProductoRequest.php) | Validación de creación |
| [resources/views/producto/create.blade.php](resources/views/producto/create.blade.php) | Formulario de creación |
| [app/Listeners/UpdateInventarioCompraListener.php](app/Listeners/UpdateInventarioCompraListener.php) | Actualiza inventario tras compra |

## 🎯 Resumen

```
CREACIÓN DE PRODUCTO:
└─ No tiene precio definido ❌
└─ El precio se asigna DESPUÉS durante compra/venta

COMPRA:
└─ Usuario especifica precio_compra por producto
└─ Precio es específico para ese lote/transacción

VENTA:
└─ Usuario especifica precio_venta por producto  
└─ Precio es específico para esa transacción

INVENTARIO:
└─ Se actualiza automáticamente tras compra
└─ Se decrementa automáticamente tras venta
```

## ⚠️ Consideraciones

- El campo `precio` en la tabla `productos` está **DEFINIDO pero NO USADO**
- Todos los precios son **transaccionales y específicos**
- No hay un "precio estándar" del producto
- El inventario es dinámico basado en compras/ventas
