# EXPLICACIÓN DEL KARDEX - FLUJO DE PRODUCTOS Y TABLAS DE BASE DE DATOS

## 📊 1. VISTA DEL KARDEX (Cómo se muestran los productos)

Una vez que un producto se inicializa, se muestra en el Kardex con la siguiente estructura:

### Pantalla del Kardex
```
┌─────────────────────────────────────────────────────────────────────────────────────────────┐
│ KARDEX - Búsqueda de Producto                                                               │
├─────────────────────────────────────────────────────────────────────────────────────────────┤
│ Producto: [Dropdown con todos los productos]  [Buscar]                                      │
└─────────────────────────────────────────────────────────────────────────────────────────────┘

┌─────────────────────────────────────────────────────────────────────────────────────────────┐
│ TABLA KARDEX DEL PRODUCTO (Una vez seleccionado)                                            │
├────────┬───────────────┬─────────────────────────────┬─────────┬────────┬────────┬──────────┤
│ Fecha  │ Transacción   │ Descripción                 │ Entrada │ Salida │ Saldo  │ Costo    │
│ Hora   │               │                             │         │        │        │ Total    │
├────────┼───────────────┼─────────────────────────────┼─────────┼────────┼────────┼──────────┤
│22/01   │ APERTURA      │ Apertura del producto       │    100  │  -     │  100   │ 500.00   │
│14:30   │               │                             │         │        │        │          │
├────────┼───────────────┼─────────────────────────────┼─────────┼────────┼────────┼──────────┤
│22/01   │ COMPRA        │ Entrada por compra n° 5     │     50  │  -     │  150   │ 750.00   │
│15:45   │               │                             │         │        │        │          │
├────────┼───────────────┼─────────────────────────────┼─────────┼────────┼────────┼──────────┤
│22/01   │ VENTA         │ Salida por venta n° 3       │     -   │   20   │  130   │ 260.00   │
│16:20   │               │                             │         │        │        │          │
├────────┼───────────────┼─────────────────────────────┼─────────┼────────┼────────┼──────────┤
│        │               │                             │         │        │        │          │
└────────┴───────────────┴─────────────────────────────┴─────────┴────────┴────────┴──────────┘

FÓRMULA DEL SALDO:
  - Saldo = (Última cantidad en kardex) + Entrada - Salida
  - Costo Total = Saldo × Costo Unitario
```

### Campos mostrados en la tabla:
| Campo | Descripción |
|-------|-------------|
| **Fecha y Hora** | Timestamp de cuándo ocurrió la transacción |
| **Transacción** | Tipo: APERTURA, COMPRA, VENTA o AJUSTE |
| **Descripción** | Detalle de la transacción (ej: "Entrada de producto por compra n°5") |
| **Entrada** | Cantidad que ingresa al inventario |
| **Salida** | Cantidad que sale del inventario |
| **Saldo** | Stock actual después de la transacción |
| **Costo Unitario** | Costo registrado en el momento |
| **Costo Total** | Saldo × Costo Unitario |

---

## 📂 2. TABLAS DE LA BASE DE DATOS CUANDO SE INICIALIZA UN PRODUCTO

### Flujo de Inicialización:

```
┌──────────────────────────────────────┐
│  1. Crear Producto                   │
│  GET: /inventario/{producto}/create  │
└─────────────────┬────────────────────┘
                  │
                  ↓
┌──────────────────────────────────────────────────────────────┐
│  2. Rellenar datos y hacer POST a /inventario (store)        │
│                                                               │
│  Datos requeridos:                                            │
│  - producto_id: ID del producto                              │
│  - cantidad: Cantidad inicial                                │
│  - costo_unitario: Precio de costo                           │
│  - ubicacione_id: Dónde se almacena                          │
└─────────────────┬──────────────────────────────────────────────┘
                  │
                  ↓ (InventarioControlller.store)
        ┌─────────┴────────────┐
        ↓                      ↓
   ┌─────────────────┐   ┌──────────────────┐
   │  TABLA KARDEX   │   │ TABLA INVENTARIO │
   └─────────────────┘   └──────────────────┘
        │                     │
        ├─ tipo: APERTURA     ├─ producto_id
        ├─ entrada: 100       ├─ ubicacione_id
        ├─ salida: NULL       ├─ cantidad: 100
        ├─ saldo: 100         ├─ cantidad_minima
        ├─ costo_unitario     └─ cantidad_maxima
        └─ descripción        └─ fecha_vencimiento
```

### Tablas involucradas en la INICIALIZACIÓN:

#### **TABLA: `productos`**
Se actualiza el estado del producto a "activo"
```sql
┌────────────────────────────────────────────────────────────┐
│ productos                                                   │
├────────────────────────────────────────────────────────────┤
│ id              → ID único del producto                     │
│ codigo          → Código único del producto                │
│ nombre          → Nombre del producto                      │
│ descripcion     → Descripción                              │
│ img_path        → Imagen del producto                      │
│ precio          → Precio de venta (se calcula automático)  │
│ estado          → 0 (No inicializado) → 1 (Inicializado)   │
│ marca_id        → Referencia a tabla marcas                │
│ presentacione_id → Referencia a tabla presentaciones       │
│ categoria_id    → Referencia a tabla categorias            │
│ created_at      → Fecha de creación                        │
│ updated_at      → Fecha de actualización                   │
└────────────────────────────────────────────────────────────┘
```

#### **TABLA: `inventario`** ✅ (Creada durante inicialización)
Almacena el stock físico del producto
```sql
┌────────────────────────────────────────────────────────────┐
│ inventario                                                  │
├────────────────────────────────────────────────────────────┤
│ id                  → ID único del registro                 │
│ producto_id         → FK a productos (UNIQUE)              │
│ ubicacione_id       → FK a ubicaciones (dónde está)        │
│ cantidad            → Stock disponible (100)               │
│ cantidad_minima     → Mínimo permitido (NULL)              │
│ cantidad_maxima     → Máximo permitido (NULL)              │
│ fecha_vencimiento   → Fecha de vencimiento (NULL)          │
│ created_at          → Fecha de creación                    │
│ updated_at          → Fecha de actualización               │
└────────────────────────────────────────────────────────────┘
```

#### **TABLA: `kardex`** ✅ (Creado durante inicialización)
Registro de todas las transacciones del producto
```sql
┌────────────────────────────────────────────────────────────┐
│ kardex                                                      │
├────────────────────────────────────────────────────────────┤
│ id                      → ID único                          │
│ producto_id             → FK a productos                   │
│ tipo_transaccion        → APERTURA (ENUM)                  │
│ descripcion_transaccion → "Apertura del producto"          │
│ entrada                 → 100 (cantidad inicial)           │
│ salida                  → NULL                             │
│ saldo                   → 100 (stock resultante)           │
│ costo_unitario          → 5.00 (precio de costo)           │
│ created_at              → Timestamp de la transacción      │
│ updated_at              → Timestamp de actualización       │
└────────────────────────────────────────────────────────────┘
```

### Ubicaciones relacionadas:
- **TABLA: `ubicaciones`** - Dónde se almacena el producto
- **TABLA: `caracteristicas`** - Características de marca/categoría/presentación

---

## 📥 3. TABLAS CUANDO SE REALIZA UNA COMPRA

### Flujo de Compra:

```
┌──────────────────────────────────────────────────────────┐
│  1. Crear Compra                                         │
│  GET: /compras/create                                    │
└─────────────────┬────────────────────────────────────────┘
                  │
                  ↓
┌──────────────────────────────────────────────────────────┐
│  2. Seleccionar Producto, Cantidad, Precio               │
│  Agregar múltiples productos a la tabla de detalle       │
│  Seleccionar Proveedor, Método de Pago, Comprobante      │
└─────────────────┬────────────────────────────────────────┘
                  │
                  ↓
┌──────────────────────────────────────────────────────────┐
│  3. POST: /compras (CompraController.store)              │
└─────────────────┬────────────────────────────────────────┘
                  │
          ┌───────┴───────┐
          ↓               ↓
    ┌──────────────┐  ┌──────────────────────┐
    │ TABLA COMPRA │  │ TABLA COMPRA_PRODUCTO│
    └──────────────┘  └──────────────────────┘
          │               │
          ├─ id           ├─ id
          ├─ user_id      ├─ compra_id
          ├─ proveedor_id ├─ producto_id
          ├─ comprobante  ├─ cantidad (50)
          ├─ numero       ├─ precio_compra (10.50)
          ├─ metodo_pago  ├─ fecha_vencimiento
          ├─ fecha_hora   └─ timestamps
          ├─ impuesto
          ├─ subtotal
          ├─ total
          └─ timestamps
                   │
                   ↓ (Evento: CreateCompraDetalleEvent)
          ┌──────────────────────┐
          │ TABLA KARDEX         │
          │ (Nuevo registro)     │
          ├──────────────────────┤
          │ tipo: COMPRA         │
          │ entrada: 50          │
          │ salida: NULL         │
          │ saldo: +50           │
          │ descripción: "Entrada│
          │  por compra n° 5"    │
          └──────────────────────┘
                   │
                   ↓ (Observer: InventarioObserver)
          ┌──────────────────────┐
          │ TABLA INVENTARIO     │
          │ (Se actualiza)       │
          ├──────────────────────┤
          │ cantidad: +50        │
          │ (nueva cantidad)     │
          └──────────────────────┘
```

### Tablas involucradas en COMPRA:

#### **TABLA: `compras`** ✅ (Creada)
Encabezado de la compra
```sql
┌────────────────────────────────────────────────────────────┐
│ compras                                                     │
├────────────────────────────────────────────────────────────┤
│ id                  → ID único de la compra                │
│ user_id             → FK a users (quién compra)           │
│ comprobante_id      → FK a comprobantes (tipo documento)  │
│ proveedore_id       → FK a proveedores                    │
│ numero_comprobante  → Número del comprobante              │
│ comprobante_path    → Ruta del archivo PDF                │
│ metodo_pago         → EFECTIVO o TARJETA                  │
│ fecha_hora          → Cuándo se realiza                   │
│ impuesto            → Monto del impuesto                  │
│ subtotal            → Total sin impuesto                  │
│ total               → Total con impuesto                  │
│ created_at          → Timestamp                           │
│ updated_at          → Timestamp                           │
└────────────────────────────────────────────────────────────┘
```

#### **TABLA: `compra_producto`** ✅ (Creada por cada producto)
Detalle de los productos comprados
```sql
┌────────────────────────────────────────────────────────────┐
│ compra_producto (TABLA PIVOTE)                              │
├────────────────────────────────────────────────────────────┤
│ id                  → ID único                             │
│ compra_id           → FK a compras                         │
│ producto_id         → FK a productos                       │
│ cantidad            → 50 (unidades compradas)              │
│ precio_compra       → 10.50 (precio unitario)              │
│ fecha_vencimiento   → 2026-12-31 (opcional)                │
│ created_at          → Timestamp                            │
│ updated_at          → Timestamp                            │
└────────────────────────────────────────────────────────────┘
```

#### **TABLA: `kardex`** ✅ (Nuevo registro por cada producto)
Se crea automáticamente un registro COMPRA
```sql
┌────────────────────────────────────────────────────────────┐
│ kardex (NUEVO REGISTRO)                                     │
├────────────────────────────────────────────────────────────┤
│ id                      → ID único                         │
│ producto_id             → FK a productos                   │
│ tipo_transaccion        → COMPRA (ENUM)                   │
│ descripcion_transaccion → "Entrada por compra n° 5"        │
│ entrada                 → 50 (cantidad agregada)           │
│ salida                  → NULL                             │
│ saldo                   → 150 (saldo anterior + entrada)   │
│ costo_unitario          → 10.50 (precio de la compra)      │
│ created_at              → Timestamp                        │
│ updated_at              → Timestamp                        │
└────────────────────────────────────────────────────────────┘
```

#### **TABLA: `inventario`** (Se actualiza)
Se incrementa la cantidad
```sql
ANTES DE COMPRA:
  cantidad = 100

DESPUÉS DE COMPRA (50 unidades):
  cantidad = 150
```

### Tablas relacionadas:
- **TABLA: `proveedores`** - Información del proveedor
- **TABLA: `comprobantes`** - Tipo de documento (Factura, Nota de Crédito, etc.)
- **TABLA: `usuarios`** - Quién realizó la compra

---

## 🔄 CICLO COMPLETO DE UN PRODUCTO

```
┌─────────────────────────────────────────────────────────────────┐
│                   CICLO DE VIDA DE UN PRODUCTO                  │
└─────────────────────────────────────────────────────────────────┘

PASO 1: CREAR PRODUCTO
   producto: estado = 0 (Inactivo, no inicializado)
   ↓

PASO 2: INICIALIZAR PRODUCTO (Inventario)
   ✓ inventario: cantidad = 100
   ✓ kardex: tipo = APERTURA, saldo = 100
   ✓ productos: estado = 1 (Activo, inicializado)
   ↓

PASO 3: HACER COMPRA
   ✓ compras: nueva compra
   ✓ compra_producto: detalle de productos
   ✓ kardex: tipo = COMPRA, entrada = 50, saldo = 150
   ✓ inventario: cantidad = 150
   ↓

PASO 4: VENDER PRODUCTO
   ✓ ventas: nueva venta
   ✓ producto_venta: detalle de productos
   ✓ kardex: tipo = VENTA, salida = 20, saldo = 130
   ✓ inventario: cantidad = 130
```

---

## 📋 RESUMEN DE TABLAS CLAVE

| Tabla | Propósito | Cuándo se usa |
|-------|-----------|---------------|
| **productos** | Catálogo maestro | Siempre |
| **inventario** | Stock actual del producto | Inicialización y cambios |
| **kardex** | Historial de movimientos | Cada transacción |
| **compras** | Encabezado de compra | Al comprar |
| **compra_producto** | Detalle de productos comprados | Al comprar |
| **ventas** | Encabezado de venta | Al vender |
| **producto_venta** | Detalle de productos vendidos | Al vender |

---

## 🔗 RELACIONES DE BASE DE DATOS

```
productos
  ├─ 1:1 → inventario (cada producto tiene un inventario)
  ├─ 1:N → kardex (cada producto tiene muchos registros)
  ├─ M:N → compras (a través de compra_producto)
  ├─ M:N → ventas (a través de producto_venta)
  ├─ N:1 → categorias
  ├─ N:1 → marcas
  └─ N:1 → presentaciones

compras
  ├─ N:1 → proveedores
  ├─ N:1 → usuarios
  ├─ N:1 → comprobantes
  └─ M:N → productos (a través de compra_producto)
```

---

## 💾 DIAGRAMA DE FLUJO DE DATOS

```
INICIALIZACIÓN
  ├── Producto (id: 1, estado: 0)
  ├── + Inventario (cantidad: 100, costo: 5.00)
  ├── + Kardex APERTURA (entrada: 100, saldo: 100)
  └── → Producto (estado: 1) ✓

COMPRA
  ├── Compra (id: 5, total: 525)
  ├── + Compra_Producto (cantidad: 50, precio: 10.50)
  ├── + Kardex COMPRA (entrada: 50, saldo: 150, costo: 10.50)
  └── + Inventario (cantidad: 150) ✓

VENTA
  ├── Venta (id: 3, total: 200)
  ├── + Producto_Venta (cantidad: 20, precio: 10)
  ├── + Kardex VENTA (salida: 20, saldo: 130)
  └── + Inventario (cantidad: 130) ✓
```
