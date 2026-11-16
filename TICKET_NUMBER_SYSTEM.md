# Documentación del Sistema de Generación de Números de Boleta

## Overview

El sistema de generación de números de boleta es un servicio independiente diseñado para manejar la creación segura y ordenada de identificadores únicos para movimientos de entrada/salida (apertura y cierre de contenedores reefer).

## Formato de Boleta

```
AAAA-CCCCCCC
```

**Componentes:**
- **AAAA**: Año de emisión (4 dígitos) - Ej: 2026
- **CCCCCCC**: Correlativo (7 dígitos, reinicia cada año) - Ej: 0000001

**Ejemplo completo:** `2026-0000001`

## Estructura de la Tabla `boleta_counters`

```sql
CREATE TABLE boleta_counters (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    year SMALLINT UNIQUE NOT NULL,
    next_sequence BIGINT NOT NULL DEFAULT 1,
    created_at TIMESTAMP,
    updated_at TIMESTAMP,
    INDEX (year)
);
```

**Propósito:** Almacenar el próximo número secuencial a generar para cada año.

## Ubicación del Código

### Archivo de Servicio
- **Ruta:** `app/Services/TicketNumberService.php`
- **Namespace:** `App\Services`
- **Clase Principal:** `TicketNumberService`

### Archivo de Migración
- **Ruta:** `database/migrations/2026_11_16_163900_create_boleta_counters_table.php`
- **Tabla:** `boleta_counters`

## Métodos Disponibles

### 1. `generateTicketNumber(): string`

Genera un nuevo número de boleta seguro ante concurrencia.

**Características:**
- Genera de forma segura en entornos concurrentes
- Usa transacciones de base de datos con bloqueos
- Incrementa automáticamente el contador
- Reinicia el correlativo cada año

**Uso:**
```php
$ticketService = new TicketNumberService();
$ticketNumber = $ticketService->generateTicketNumber();
// Resultado: "2026-0000001"
```

### 2. `getNextTicketNumber(?int $year = null): string`

Obtiene el número de boleta que se generaría a continuación sin incrementar el contador.

**Uso:**
```php
$nextTicket = $ticketService->getNextTicketNumber();
// Resultado: "2026-0000001" (sin incrementar)
```

### 3. `getNextSequence(?int $year = null): int`

Obtiene solo el número secuencial siguiente para un año.

**Uso:**
```php
$sequence = $ticketService->getNextSequence();
// Resultado: 1
```

### 4. `getCounterStats(?int $year = null): array`

Obtiene estadísticas completas del contador para un año.

**Retorno:**
```php
[
    'year' => 2026,
    'next_sequence' => 42,
    'total_generated' => 41,
    'exists' => true,
    'created_at' => '2026-11-16 16:39:00',
    'updated_at' => '2026-11-16 16:40:30'
]
```

### 5. `resetCounterForYear(int $year, int $startSequence = 1): bool`

Reinicia el contador para un año específico (uso administrativo).

**Uso:**
```php
$ticketService->resetCounterForYear(2026, 1);
```

### 6. `isValidFormat(string $ticketNumber): bool` (Estático)

Valida que un número de boleta tenga el formato correcto.

**Uso:**
```php
TicketNumberService::isValidFormat('2026-0000001'); // true
TicketNumberService::isValidFormat('2026-123');      // false
```

### 7. `parseTicketNumber(string $ticketNumber): ?array` (Estático)

Extrae el año y correlativo de un número de boleta.

**Uso:**
```php
$parsed = TicketNumberService::parseTicketNumber('2026-0000001');
// Resultado: ['year' => 2026, 'sequence' => 1]
```

## Garantías de Concurrencia

El sistema garantiza que dos solicitudes simultáneas nunca generarán el mismo número de boleta mediante:

1. **Transacciones ACID**: Uso de `DB::transaction()`
2. **Bloqueos de escritura**: `lockForUpdate()` en lectura
3. **Incremento atómico**: El incremento del contador ocurre dentro de la transacción

## Flujo de Integración Futuro

### Fase 2 (Apertura de Condición)
Cuando se abra una condición:
1. Sistema genera número de boleta → `2026-0000001`
2. Se inserta en `movimientos` con `mov_tipomovimiento = 'salida'`
3. Se almacena el número en `mov_boleta`

### Fase 3 (Cierre de Condición)
Cuando se cierre la condición:
1. Se recupera el número de boleta de la apertura → `2026-0000001`
2. Se inserta nuevo registro en `movimientos` con `mov_tipomovimiento = 'ingreso'`
3. Se usa el MISMO número de boleta en `mov_boleta`

**Resultado:** Dos movimientos (salida e ingreso) compartirán el mismo número de boleta.

## Reutilización de Números

Aunque el nombre sugiere "reutilización", en realidad no se genera un nuevo número. El flujo es:

```
1. Apertura: Se genera "2026-0000001"
   - INSERT movimientos (mov_boleta='2026-0000001', mov_tipomovimiento='salida')

2. Cierre: Se REUTILIZA "2026-0000001" (sin generar nuevo)
   - INSERT movimientos (mov_boleta='2026-0000001', mov_tipomovimiento='ingreso')

Resultado: Dos filas en la tabla movimientos con la misma boleta
```

## Notas Importantes

### No se ejecutan migraciones en esta fase
La migración está lista pero NO se debe ejecutar `php artisan migrate` hasta que se integre con el formulario de movimientos.

### Independencia del servicio
El servicio NO depende de:
- Formularios de movimientos
- Controladores de movimientos
- Procesos de apertura/cierre
- Tabla de movimientos

### Listo para integración
El código está completamente preparado para:
- Ser inyectado en controladores
- Ser utilizado en comandos de Artisan
- Ser usado en observadores de modelos
- Ser integrado en servicios de negocio

## Ejemplo de Uso (Futuro)

```php
<?php

namespace App\Http\Controllers;

use App\Services\TicketNumberService;

class MovimientosController extends Controller
{
    protected TicketNumberService $ticketService;

    public function __construct(TicketNumberService $ticketService)
    {
        $this->ticketService = $ticketService;
    }

    public function abrirCondicion(Request $request)
    {
        // Generar boleta
        $ticketNumber = $this->ticketService->generateTicketNumber();

        // Crear movimiento
        Movimiento::create([
            'mov_boleta' => $ticketNumber,
            'mov_tipomovimiento' => 'salida',
            // ... otros campos
        ]);
    }

    public function cerrarCondicion($movimientoId)
    {
        // Obtener movimiento de apertura
        $aperturaMovimiento = Movimiento::find($movimientoId);

        // Crear movimiento de cierre con la MISMA boleta
        Movimiento::create([
            'mov_boleta' => $aperturaMovimiento->mov_boleta, // Reutilizar
            'mov_tipomovimiento' => 'ingreso',
            // ... otros campos
        ]);
    }
}
```

## Testing

Para probar el servicio sin ejecutar migraciones:

```php
<?php

namespace Tests\Feature;

use App\Services\TicketNumberService;
use Tests\TestCase;

class TicketNumberServiceTest extends TestCase
{
    public function test_generates_valid_ticket_number()
    {
        $service = new TicketNumberService();
        // Nota: requiere que la tabla boleta_counters exista
        // Usar fixtures o setup de test para simularla
    }

    public function test_format_validation()
    {
        $this->assertTrue(TicketNumberService::isValidFormat('2026-0000001'));
        $this->assertFalse(TicketNumberService::isValidFormat('invalid'));
    }

    public function test_parse_ticket_number()
    {
        $parsed = TicketNumberService::parseTicketNumber('2026-0000001');
        $this->assertEquals(['year' => 2026, 'sequence' => 1], $parsed);
    }
}
```

## Consideraciones de Producción

### Base de datos
- Usar base de datos con soporte de transacciones ACID (MySQL 5.7+, PostgreSQL)
- El campo `next_sequence` debe ser BIGINT para soportar hasta ~9 millones de boletas por año

### Monitoreo
- Monitorear el incremento del contador
- Alertar si se acerca a 9999999 boletas en un año

### Respaldos
- La tabla `boleta_counters` es crítica, incluir en estrategia de respaldo
- Considerar replicación en tiempo real

### Auditoría
Futuro: Registrar auditoría de generación de boletas en tabla separada si es requerido.
