# MANUAL DE PRUEBAS - PHASE 2: Guardado de Movimientos de Salida

## Requisitos Previos

1. **Base de datos actualizada**
   ```bash
   php artisan migrate
   ```
   - ✓ Verificar que `boleta_counters` existe
   - ✓ Verificar que `movimientos` tiene índice único compuesto

2. **Servidor corriendo**
   ```bash
   php artisan serve
   ```
   - Por defecto en: http://localhost:8000

3. **Usuario autenticado**
   - Debe tener recinto asignado (campo `recinto` en users)
   - Debe tener permiso "Ver Salidas"

---

## Prueba 1: Acceder al Formulario

### Paso a Paso

1. Ir a: `http://localhost:8000/salidas`
2. Verificar que se muestra el formulario "REGISTRO DE SALIDA DE EQUIPO | PUERTO BARRIOS"
3. Verificar que el campo "Boleta / EIR" está vacío y es readonly (gris, no se puede escribir)
4. Verificar que el placeholder dice "Se genera automáticamente"

### Resultado Esperado
- ✓ Formulario cargado correctamente
- ✓ Campo de boleta vacío y deshabilitado

---

## Prueba 2: Validación de Campos Obligatorios

### Paso a Paso

1. Dejar todos los campos vacíos
2. Hacer clic en "GUARDAR"
3. Verificar mensajes de error en la consola (browser dev tools)

### Resultado Esperado
- ✓ Error 422 (Unprocessable Entity)
- ✓ Mensajes de error para campos requeridos
- ✓ Botón "GUARDAR" se re-habilita

---

## Prueba 3: Envío Exitoso (Principal)

### Preparación de Datos

1. **Datos Generales** (rellenar):
   - Recinto: (auto-cargado de usuario logueado)
   - Fecha: (auto-completado con hoy)
   - Hora: 14:30
   - Cabezal: 100 (o "AGREGADO")
   - Placa Cabezal: C-123ABC
   - Kilometraje: 50000

2. **Contenedor** (opcional, dejar vacío):
   - Dejar en blanco

3. **Comercial** (rellenar):
   - Contenido: DIVERSOS
   - Cliente: CLIENTE X
   - Conductor: JUAN PEREZ

4. **Chassis** (rellenar):
   - Chassis: CH-2024-001 (o número existente)
   - Placa Chassis: C-456DEF

5. **Genset** (opcional, dejar vacío):
   - No marcar checkbox

6. **Combustible** (opcional, dejar vacío):
   - No marcar checkbox

7. **Llantas 1-8** (rellenar, OBLIGATORIAS):
   - Para cada llanta:
     - Quemado: 2
     - Profundidad: 7
     - Marca: MICHELIN

8. **Llantas 9-12** (opcional):
   - Dejar vacías

9. **Inspecciones** (si existe la sección):
   - Rellenar según sea necesario

10. **Observaciones** (opcional):
    - Dejar vacía o agregar nota

### Paso a Paso

1. Completar todos los campos requeridos como se describe arriba
2. Hacer clic en "GUARDAR"
3. Esperar respuesta del servidor (máx 3 segundos)

### Resultado Esperado
- ✓ Botón "GUARDAR" deshabilitado con texto "Guardando..."
- ✓ Alert: "✓ Movimiento de salida registrado exitosamente. Boleta: 2026-0000001"
  - **IMPORTANTE**: La boleta debe estar en formato AAAA-CCCCCCC
- ✓ Campo "Boleta / EIR" se rellena con el número generado
- ✓ Redirección automática a `/salidas` (formulario en blanco)

---

## Prueba 4: Verificación de Datos Guardados

### En la Base de Datos

```sql
-- Verificar que el movimiento se guardó
SELECT * FROM movimientos 
WHERE mov_boleta = '2026-0000001'
ORDER BY mov_id DESC 
LIMIT 1;

-- Verificar que tiene tipo "salida"
SELECT mov_id, mov_boleta, mov_tipomovimiento, mov_fecha, mov_hora, mov_cabezal
FROM movimientos 
WHERE mov_boleta = '2026-0000001';

-- Verificar contador de boletas
SELECT * FROM boleta_counters WHERE year = 2026;
```

### Resultado Esperado
- ✓ Un registro en `movimientos` con `mov_boleta = '2026-0000001'`
- ✓ Campo `mov_tipomovimiento = 'salida'`
- ✓ Todos los campos llenados coinciden con el formulario
- ✓ `boleta_counters` muestra `next_sequence = 2` (incrementó)

---

## Prueba 5: Generación Correlativa de Boletas

### Paso a Paso

1. Completar y enviar el formulario 3 veces más con datos diferentes
2. Verificar que cada boleta es única y secuencial

### Resultado Esperado
- ✓ Boleta 1: `2026-0000001`
- ✓ Boleta 2: `2026-0000002`
- ✓ Boleta 3: `2026-0000003`
- ✓ Boleta 4: `2026-0000004`

```sql
SELECT mov_boleta, mov_tipomovimiento, COUNT(*) 
FROM movimientos 
GROUP BY mov_boleta, mov_tipomovimiento;
```

---

## Prueba 6: Prevención de Duplicados por Doble Clic

### Paso a Paso

1. Completar el formulario
2. Hacer clic en "GUARDAR" **dos veces rápidamente**
3. Verificar que solo se guardó UNA vez

### Resultado Esperado
- ✓ Primer submit: procesado exitosamente, boleta generada
- ✓ Segundo submit: bloqueado (botón deshabilitado)
- ✓ Un solo registro en BD

```sql
SELECT COUNT(*) FROM movimientos WHERE mov_boleta = '2026-0000005' AND mov_tipomovimiento = 'salida';
-- Debe devolver: 1 (no 2)
```

---

## Prueba 7: Validación de Restricción Única

### Objetivo
Verificar que no se pueden guardar dos "salidas" con la misma boleta,
pero SÍ se puede guardar "salida" + "ingreso" con la misma boleta (preparación para Phase 3)

### Paso a Paso (simulación, se puede hacer manualmente en DB)

```sql
-- Esta operación debe FALLAR (dos salidas con misma boleta)
INSERT INTO movimientos (
    mov_boleta, 
    mov_tipomovimiento, 
    mov_fecha, 
    mov_hora, 
    mov_recinto,
    mov_cabezal,
    mov_placacabezal,
    mov_contenido,
    mov_conductor,
    mov_chassis,
    mov_digitador,
    mov_condicionista,
    mov_llanta1_quemado,
    mov_llanta1_profundidad,
    mov_llanta1_marca,
    -- ... más campos requeridos ...
    created_at,
    updated_at
) VALUES (
    '2026-0000001',  -- MISMA boleta
    'salida',        -- MISMO tipo
    NOW(),
    '14:30',
    1,
    '100',
    'C-123ABC',
    'DIVERSOS',
    'JUAN',
    'CH-001',
    1,
    2,
    2,
    7,
    'MICHELIN',
    -- ...
    NOW(),
    NOW()
);
-- Error esperado: Violation of PRIMARY KEY or UNIQUE KEY constraint

-- Pero esta operación DEBE SER POSIBLE (una salida y un ingreso)
-- Se implementará en Phase 3
```

### Resultado Esperado
- ✓ BD rechaza inserción de dos "salida" con misma boleta
- ✓ BD permite "salida" + "ingreso" con misma boleta
- ✓ Error: `Duplicate entry '2026-0000001-salida'`

---

## Prueba 8: Mapeo de Campos de Llantas

### Verificar que los nombres se mapean correctamente

```sql
-- Verificar que los 36 campos de llantas se guardaron
SELECT 
    mov_llanta1_quemado, mov_llanta1_profundidad, mov_llanta1_marca,
    mov_llanta2_quemado, mov_llanta2_profundidad, mov_llanta2_marca,
    -- ... etc hasta llanta 12 ...
FROM movimientos 
WHERE mov_boleta = '2026-0000001';
```

### Resultado Esperado
- ✓ Todos los campos de llantas 1-8 llenados
- ✓ Llantas 9-12 vacías (no eran obligatorias)
- ✓ Valores corresponden con lo ingresado en formulario

---

## Prueba 9: Mapeo de Campos de Combustible y Genset

### Verificar que se calcula diferencia y se mapean correctamente

```sql
-- Si se rellenó combustible:
SELECT 
    mov_comb_galones_salida,
    mov_comb_carga,
    mov_gal_diferencia,
    mov_comb_tanque,
    mov_comb_puerta,
    mov_comb_panel_1,
    mov_comb_panel_2
FROM movimientos 
WHERE mov_boleta = '2026-0000001';
```

### Resultado Esperado
- ✓ `mov_gal_diferencia = mov_comb_galones_salida - mov_comb_carga`
- ✓ Otros campos mapeados correctamente
- ✓ NULL para campos opcionales no rellenados

---

## Prueba 10: Error de Validación

### Paso a Paso

1. Completar formulario pero dejar una llanta vacía (1-8)
2. Cambiar placa a "INVALIDA" (no es C-123ABC)
3. Hacer clic en GUARDAR

### Resultado Esperado
- ✓ Error 422 con validación fallida
- ✓ Mensajes de error en la respuesta JSON
- ✓ Botón se re-habilita

---

## Prueba 11: Verificación de Logs

### Ver logs de la aplicación

```bash
tail -f storage/logs/laravel.log
```

Buscar líneas con:
- `Movimiento de salida guardado exitosamente` (éxito)
- `Error al guardar movimiento de salida` (fallo)

### Resultado Esperado
- ✓ Log del éxito con `mov_id` y `mov_boleta`
- ✓ Log del usuario que realizó el movimiento (`user_id`)

---

## Prueba 12: Incremento de Año

### Cambiar la fecha del servidor a próximo año y probar

1. Cambiar fecha del sistema a 2027-01-01
2. Generar una nueva boleta
3. Verificar BD

### Resultado Esperado
- ✓ Nueva boleta: `2027-0000001` (año diferente, correlativo reinicia)
- ✓ Tabla `boleta_counters` tiene dos filas: una para 2026 y otra para 2027

```sql
SELECT year, next_sequence FROM boleta_counters ORDER BY year;
-- Resultado:
-- 2026 | 5 (o más)
-- 2027 | 2 (empezó en 1, después de generar la primera)
```

---

## Checklist de Validación Final

- [ ] Formulario cargado correctamente
- [ ] Campo boleta deshabilitado
- [ ] Validaciones funcionan
- [ ] Boleta generada en formato AAAA-CCCCCCC
- [ ] Movimiento guardado con tipo "salida"
- [ ] Correlativo secuencial
- [ ] No permite doble clic
- [ ] Restricción de BD funciona
- [ ] Campos mapeados correctamente
- [ ] Diferencia de combustible calculada
- [ ] Logs registrados
- [ ] Reinicio anual funciona

---

## Troubleshooting

### "Error: recinto not found on user"
**Solución**: El usuario no tiene recinto asignado. Ir a usuarios y asignar un recinto.

### "Error: mov_boleta not unique"
**Solución**: Ya existe una salida con esa boleta. Verificar que `TicketNumberService` está generando nuevas boletas.

### "Validation failed: placa_cabezal"
**Solución**: La placa no sigue formato C-\d{3}[A-Z]{3}. Usar: C-123ABC

### "Cannot generate ticket: facade root not set"
**Solución**: Error de inicialización. Verificar que las migraciones se ejecutaron.

### "Error 500: Undefined table movimientos"
**Solución**: Las migraciones no se ejecutaron. Correr `php artisan migrate`.

---

## Notas para Phase 3

La estructura está lista para registrar movimientos de ingreso:
1. El endpoint será `POST /ingresos`
2. Se buscará la boleta existente de salida
3. Se verificará que no haya ingreso duplicado
4. Se utilizará la misma boleta (mismo número)
5. Se establecerá `mov_tipomovimiento = 'ingreso'`

