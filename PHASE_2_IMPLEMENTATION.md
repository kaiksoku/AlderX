# PHASE 2: Implementar Guardado de Movimientos de Salida

## ✓ COMPLETADO - Estado Actual

La implementación de Phase 2 ha sido completada exitosamente. El sistema está listo para:
- Registrar movimientos de salida (apertura de condiciones)
- Generar automáticamente boletas en formato AAAA-CCCCCCC
- Permitir reutilización de boletas entre salida e ingreso
- Validar toda la información del formulario
- Garantizar integridad de datos con transacciones

---

## 📁 Archivos Creados en Phase 2

### 1. **app/Services/GuardarMovimientoSalidaService.php** (NUEVO)
   - **Ubicación**: `C:\laragon\www\AlderX\app\Services\GuardarMovimientoSalidaService.php`
   - **Propósito**: Servicio encapsulado para guardar movimientos de salida
   - **Funcionalidades**:
     - Integra TicketNumberService para generar boletas
     - Mapea campos del formulario a columnas de BD
     - Ejecuta operaciones en transacción
     - Registra eventos de éxito/error
     - Calcula diferencias de combustible
     - Maneja valores nulos para campos opcionales

---

## 📝 Archivos Modificados en Phase 2

### 1. **app/Http/Controllers/SalidasController.php** (ACTUALIZADO)
   - **Cambios**:
     - Inyección de `GuardarMovimientoSalidaService` en constructor
     - Implementación del método `store()` que:
       - Valida autorización y recinto del usuario
       - Llama al servicio para guardar movimiento
       - Retorna JSON con boleta generada
       - Maneja excepciones con mensajes de error
   - **Métodos existentes preservados**: `show()`, `validarChassis()`, `validarGenset()`

### 2. **routes/web.php** (ACTUALIZADO)
   - **Cambio**: Agregada ruta POST
   ```php
   Route::post('salidas', [SalidasController::class, 'store'])
       ->middleware(['auth', 'can:Ver Salidas'])
       ->name('salidas.store');
   ```

### 3. **resources/views/Operaciones/Salidas/salidascreate.blade.php** (ACTUALIZADO)
   - **Cambios**:
     - Agregado `action="{{ route('salidas.store') }}"` al formulario
     - Campo `mov_boleta` ahora es **readonly** (no permite entrada manual)
     - Implementado JavaScript para:
       - Envío AJAX del formulario
       - Recepción de boleta generada
       - Visualización de confirmación
       - Redirección automática tras éxito
     - Preservados todos los campos del formulario original (100+)

---

## 🗄️ Cambios en Base de Datos

### Migraciones Ejecutadas

#### 1. **2026_11_16_163900_create_boleta_counters_table**
   - **Estado**: ✓ Ejecutada
   - **Tabla creada**: `boleta_counters`
   - **Campos**:
     - `id` (Primary Key)
     - `year` (integer) - Año para reinicio anual
     - `next_sequence` (integer) - Próximo correlativo
     - `created_at`, `updated_at` - Timestamps
   - **Propósito**: Almacenar contador seguro de boletas por año

#### 2. **2026_11_16_164500_modify_movimientos_boleta_constraint**
   - **Estado**: ✓ Ejecutada
   - **Tabla modificada**: `movimientos`
   - **Cambios**:
     - **Removido**: Índice único `UNIQUE(mov_boleta)`
     - **Agregado**: Índice único compuesto `UNIQUE(mov_boleta, mov_tipomovimiento)`
   - **Efecto**: 
     - ✓ Permite: `2026-0000001 salida` + `2026-0000001 ingreso`
     - ✗ Rechaza: `2026-0000001 salida` + `2026-0000001 salida` (duplicado)
     - ✗ Rechaza: `2026-0000001 ingreso` + `2026-0000001 ingreso` (duplicado)

---

## 🔧 Validación de Formulario

### Archivo: **app/Http/Requests/StoreMovimientoSalidaRequest.php**
   - **Estado**: Ya existente en Phase 1
   - **Reglas**: Validación completa de 100+ campos
   - **Campos requeridos**:
     - Datos generales: fecha, hora, cabezal, placa, contenido, conductor, condicionista
     - Chassis: número y chasis
     - Llantas 1-8 (todas obligatorias)
   - **Campos opcionales**:
     - Contenedor, naviera, genset 1 y 2, combustible, llantas 9-12
   - **Validaciones especiales**:
     - Placa cabezal: regex `C-\d{3}[A-Z]{3}`
     - Contenedor: regex `[A-Za-z]{4}\d{7}`
     - Hora: formato `H:i`

---

## 📊 Modelo: Movimiento

### Archivo: **app/Models/Movimiento.php**
   - **Tabla**: `movimientos`
   - **Primary Key**: `mov_id`
   - **Fillable**: Todos los campos del formulario + boleta + tipo movimiento
   - **Relaciones**: User (digitador, condicionista), Recintos
   - **Métodos helper**:
     - `porBoleta($boleta)` - Obtener movimientos por boleta
     - `esSalida()` - Verificar si es salida
     - `esIngreso()` - Verificar si es ingreso
     - `movimientoComplementario()` - Obtener el ingreso/salida opuesto

---

## 🔐 Seguridad Implementada

### 1. **Generación de Boleta Segura**
   - Integra TicketNumberService (Phase 1)
   - Usa `DB::transaction()` para atomicidad
   - Bloquea fila con `lockForUpdate()` contra condiciones de carrera
   - Auto-incremento seguro sin AUTOINCREMENT de BD

### 2. **Prevención de Duplicados**
   - Restricción única compuesta en BD: `(mov_boleta, mov_tipomovimiento)`
   - Garantiza que no se registren dos salidas con misma boleta
   - Permite legítimamente salida + ingreso con misma boleta

### 3. **Protección contra Reenvío**
   - Envío AJAX con botón deshabilitado tras primer submit
   - Validación en servidor antes de guardado
   - Si hay error de validación, botón se re-habilita
   - Flash token CSRF en formulario

### 4. **Integridad de Transacciones**
   - Guardado de movimiento envuelto en `DB::transaction()`
   - Si falla: rollback automático, boleta no se "consume"
   - Logs de error para auditoría

---

## 🧪 Pruebas Realizadas

### ✓ Verificaciones Completadas

1. **Migraciones**
   - [x] `2026_11_16_163900_create_boleta_counters_table` - Ejecutada
   - [x] `2026_11_16_164500_modify_movimientos_boleta_constraint` - Ejecutada
   - [x] Tabla `boleta_counters` existe con estructura correcta
   - [x] Tabla `movimientos` tiene restricción única compuesta

2. **Servicios y Modelos**
   - [x] `TicketNumberService` disponible y funcional
   - [x] `GuardarMovimientoSalidaService` disponible
   - [x] `Movimiento` model disponible con tabla correcta
   - [x] `StoreMovimientoSalidaRequest` disponible

3. **Rutas**
   - [x] GET `/salidas` - Mostrar formulario
   - [x] POST `/salidas` - Guardar movimiento
   - [x] GET `/ajax/validar-chassis` - Validar chassis
   - [x] GET `/ajax/validar-genset` - Validar genset

4. **Integración**
   - [x] GuardarMovimientoSalidaService usa TicketNumberService obligatoriamente
   - [x] Formulario mapea campos correctamente
   - [x] Boleta se genera automáticamente en controller.store()
   - [x] Movimiento se guarda con tipo "salida"

---

## 📋 Cómo Funciona el Flujo

### Paso a Paso

1. **Usuario accede al formulario**
   - GET `/salidas` → `SalidasController@show()`
   - Renderiza `salidascreate.blade.php`

2. **Usuario completa y envía formulario**
   - Formulario tiene action `{{ route('salidas.store') }}`
   - JavaScript intercepta submit y envía AJAX POST

3. **Validación del lado del cliente**
   - Hora formateada correctamente (HH:mm)
   - Mayúsculas forzadas en todos los campos
   - Validación HTML5 (required, pattern, etc.)

4. **Servidor recibe POST /salidas**
   - `StoreMovimientoSalidaRequest` valida todos los campos
   - Si hay error: retorna 422 con mensajes
   - Si es válido: continúa

5. **Generación de Boleta**
   - `GuardarMovimientoSalidaService->guardar()` inicia transacción
   - Llama a `TicketNumberService->generateTicketNumber()`
   - Obtiene boleta en formato `AAAA-CCCCCCC` (ej: `2026-0000001`)

6. **Mapeo de Campos**
   - Servicio mapea nombres del formulario a nombres de BD
   - Ejemplo: `mov_llanta1_1` → `mov_llanta1_quemado`
   - Calcula diferencia de combustible si aplica

7. **Guardado en BD**
   - `Movimiento::create($datos)` con transacción
   - Establece `mov_tipomovimiento = 'salida'`
   - Establece `mov_boleta = 'XXXX-CCCCCCC'`
   - Si falla: rollback, error a cliente

8. **Respuesta al Cliente**
   - Éxito: JSON con `status: 'success'`, `boleta`, `mov_id`
   - JavaScript muestra boleta en campo readonly
   - Muestra alert de confirmación
   - Redirige a `/salidas` (listado)

---

## 🔄 Reutilización de Boleta en Ingreso (Fase 3)

La estructura está preparada para Phase 3:

1. **El número se reutiliza automáticamente**
   - Cuando se registre `ingreso`, se buscará boleta existente
   - Mismo número de movimiento compartido entre salida e ingreso

2. **Control en BD**
   - Restricción única `(mov_boleta, mov_tipomovimiento)` lo permite
   - Query: `Movimiento::where('mov_boleta', $boleta)->where('mov_tipomovimiento', 'salida')->first()`

3. **Consideraciones**
   - El `ingreso` NO generará nueva boleta
   - El `ingreso` BUSCARÁ y verificará la boleta de `salida`
   - Ambos registros compartirán `mov_boleta` pero diferente `mov_tipomovimiento`

---

## 📚 Documentación de Referencia

### Archivos relacionados
- Phase 1: `PHASE_1_COMPLETE.md` - Generación de boletas
- Arquitectura: `ARCHITECTURE.md` - Estructura general del proyecto
- Sistema de tickets: `TICKET_NUMBER_SYSTEM.md` - Detalles técnicos

---

## ✅ Conclusión

**Phase 2 está completamente implementada y lista para testing.**

Todos los componentes están en lugar:
- ✓ Servicio de guardado encapsulado
- ✓ Validación de formulario robusta
- ✓ Generación de boleta segura
- ✓ Restricción de BD que permite reutilización controlada
- ✓ Transacciones para integridad
- ✓ Logging y manejo de errores
- ✓ Formulario actualizado sin cambios de estructura

**Próximo paso**: Phase 3 - Implementar guardado de movimientos de ingreso (cierre de condiciones) con reutilización de boleta.
