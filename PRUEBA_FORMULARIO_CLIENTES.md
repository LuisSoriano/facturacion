# 🧪 Prueba de Formularios de Cliente

## Cambios Implementados

Se ha actualizado completamente el formulario de creación y edición de clientes con validaciones dinámicas basadas en el tipo de cliente.

## 🔗 URLs para Probar

- **Crear Cliente**: `http://192.168.4.103/admin/clientes/create`
- **Editar Cliente**: `http://192.168.4.103/admin/clientes/{id}/edit`
- **Listar Clientes**: `http://192.168.4.103/admin/clientes`

## ✅ Casos de Prueba

### Caso 1: Cliente NATURAL

**Pasos:**
1. Abrir `/admin/clientes/create`
2. Seleccionar "NATURAL" en "Tipo de cliente"
3. Verificar que se muestren todos los campos:
   - Nombres y apellidos (required)
   - Dirección (optional)
   - Email (optional)
   - Teléfono (optional)
   - Tipo de documento (required) - dropdown habilitado
   - Número de documento (required)
4. Seleccionar un documento (CI, CEX, PAS, OD)
5. Llenar los datos requeridos:
   - Nombres: "Juan Pérez"
   - Tipo documento: "CI - CÉDULA DE IDENTIDAD"
   - Número: "1234567"
6. Botón "Guardar" debe habilitarse
7. Enviar formulario

**Validaciones esperadas:**
- ✓ Campo "Tipo de documento" debe permitir seleccionar cualquier opción EXCEPTO NIT
- ✓ No se debe permitir seleccionar NIT para clientes naturales
- ✓ Número de documento debe ser único

---

### Caso 2: Cliente JURÍDICA

**Pasos:**
1. Abrir `/admin/clientes/create`
2. Seleccionar "JURIDICA" en "Tipo de cliente"
3. Verificar que se muestren todos los campos
4. Verificar que:
   - Campo "Tipo de documento" muestre "NIT - NÚMERO DE IDENTIFICACIÓN TRIBUTARIA"
   - Campo "Tipo de documento" esté DESHABILITADO (no se pueda cambiar)
   - Etiqueta cambie a "Nombre de la empresa:"
5. Llenar los datos:
   - Nombre empresa: "Acme Corp"
   - Número de documento: "1234567890"
6. Botón "Guardar" debe habilitarse
7. Enviar formulario

**Validaciones esperadas:**
- ✓ Campo de documento debe estar fijo en NIT
- ✓ No se puede cambiar el tipo de documento
- ✓ Número de documento debe ser único
- ✓ Número debe cumplir con validación de NIT (máximo 20 caracteres)

---

### Caso 3: Editar Cliente NATURAL

**Pasos:**
1. Ir a `/admin/clientes` y hacer click en editar un cliente NATURAL
2. Verificar que:
   - Muestre "Tipos de cliente: NATURAL"
   - Etiqueta sea "Nombres y apellidos:"
   - Campo "Tipo de documento" esté habilitado
3. Cambiar algún dato (teléfono, email)
4. Enviar formulario

**Validaciones esperadas:**
- ✓ Debe permitir cambiar el tipo de documento
- ✓ Las validaciones deben aplicarse igual que en create

---

### Caso 4: Editar Cliente JURÍDICA

**Pasos:**
1. Ir a `/admin/clientes` y hacer click en editar un cliente JURÍDICA
2. Verificar que:
   - Muestre "Tipos de cliente: JURIDICA"
   - Etiqueta sea "Nombre de la empresa:"
   - Campo "Tipo de documento" muestre "NIT" y esté DESHABILITADO
3. Cambiar algún dato (nombre empresa, email)
4. Enviar formulario

**Validaciones esperadas:**
- ✓ Campo de documento debe estar fijo en NIT (no editable)
- ✓ Muestra mensaje: "El tipo de documento para clientes jurídicos es NIT (fijo)"

---

### Caso 5: Validación de Campos Requeridos

**Pasos (en CREATE):**
1. Abrir `/admin/clientes/create`
2. NO seleccionar tipo de cliente
3. Verificar que todos los campos estén ocultos
4. Botón "Guardar" debe estar DESHABILITADO
5. Seleccionar tipo de cliente
6. Verificar que campos se muestren
7. Llenar SOLO "Nombres y apellidos"
8. Botón "Guardar" debe seguir DESHABILITADO
9. Seleccionar tipo de documento
10. Botón "Guardar" debe seguir DESHABILITADO
11. Llenar "Número de documento"
12. Botón "Guardar" debe habilitarse

**Validaciones esperadas:**
- ✓ Campos requeridos: tipo, razón_social, documento_id, numero_documento
- ✓ Botón se habilita solo cuando todos están llenos

---

## 📋 Datos de Prueba

### Documentos disponibles:
- ID 1: CI - CÉDULA DE IDENTIDAD
- ID 2: CEX - CÉDULA DE IDENTIDAD DE EXTRANJERO
- ID 3: PAS - PASAPORTE
- ID 4: OD - OTRO DOCUMENTO DE IDENTIDAD
- ID 5: NIT - NÚMERO DE IDENTIFICACIÓN TRIBUTARIA

### Usuarios de prueba:
- Usuario: `admin@example.com`
- Contraseña: `password`

---

## 🐛 Troubleshooting

Si el formulario no carga correctamente:

1. **Limpiar caché:**
   ```bash
   php artisan view:clear
   php artisan cache:clear
   ```

2. **Verificar que jQuery está cargado:**
   - Abrir DevTools (F12)
   - Verificar que no haya errores de jQuery en consola

3. **Verificar que las rutas están correctas:**
   ```bash
   php artisan route:list | grep cliente
   ```

---

## 📝 Notas Técnicas

- **Framework:** Laravel 10
- **Base de datos:** MySQL
- **JavaScript:** jQuery 3.6.4
- **Bootstrap:** 5.x

### Archivos modificados:
- `resources/views/cliente/create.blade.php` - Formulario de creación
- `resources/views/cliente/edit.blade.php` - Formulario de edición
- `app/Http/Controllers/clienteController.php` - Controlador actualizado

### Validaciones backend (no cambiadas):
- `app/Http/Requests/StorePersonaRequest.php`
- `app/Http/Requests/UpdateClienteRequest.php`

---

¡Listo para probar! 🚀
