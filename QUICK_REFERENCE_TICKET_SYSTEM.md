# Sistema de Generación de Números de Boleta - Guía Rápida

## Resumen Ejecutivo

**Archivo principal:** [`app/Services/TicketNumberService.php`](./app/Services/TicketNumberService.php)

**Migración:** [`database/migrations/2026_11_16_163900_create_boleta_counters_table.php`](./database/migrations/2026_11_16_163900_create_boleta_counters_table.php)

**Documentación completa:** [`TICKET_NUMBER_SYSTEM.md`](./TICKET_NUMBER_SYSTEM.md)

**Tests:** [`tests/Unit/Services/TicketNumberServiceTest.php`](./tests/Unit/Services/TicketNumberServiceTest.php)

---

## Uso Básico (Cuando se integre)

```php
use App\Services\TicketNumberService;

// Generar nuevo número de boleta
$service = new TicketNumberService();
$ticketNumber = $service->generateTicketNumber();
// Resultado: "2026-0000001"

// Validar formato
if (TicketNumberService::isValidFormat($ticketNumber)) {
    // OK
}

// Extraer datos
$parsed = TicketNumberService::parseTicketNumber($ticketNumber);
// Resultado: ['year' => 2026, 'sequence' => 1]
```

---

## Formato de Boleta

```
AAAA-CCCCCCC
│    │
│    └─ Correlativo (7 dígitos, reinicia cada año)
└────── Año de emisión (4 dígitos)
```

**Ejemplos válidos:**
- `2026-0000001` ✓
- `2026-0000042` ✓
- `2025-9999999` ✓

**Ejemplos inválidos:**
- `2026-123` ✗ (correlativo muy corto)
- `26-0000001` ✗ (año de 2 dígitos)
- `2026/0000001` ✗ (separador incorrecto)

---

## Métodos Principales

### `generateTicketNumber(): string`
Genera un nuevo número secuencial. **Thread-safe.**
```php
$ticket = $service->generateTicketNumber();
```

### `getNextTicketNumber(?int $year = null): string`
Obtiene el próximo número sin incrementar.
```php
$preview = $service->getNextTicketNumber();
```

### `getCounterStats(?int $year = null): array`
Obtiene estadísticas del contador.
```php
$stats = $service->getCounterStats();
// ['year' => 2026, 'next_sequence' => 42, 'total_generated' => 41, ...]
```

### `TicketNumberService::isValidFormat(string $ticketNumber): bool`
Valida el formato (estático).
```php
if (TicketNumberService::isValidFormat('2026-0000001')) { }
```

### `TicketNumberService::parseTicketNumber(string $ticketNumber): ?array`
Extrae componentes (estático).
```php
$data = TicketNumberService::parseTicketNumber('2026-0000001');
// ['year' => 2026, 'sequence' => 1]
```

---

## Garantías de Concurrencia

✓ Dos solicitudes simultáneas NUNCA generarán el mismo número.

✓ Usa `DB::transaction()` + `lockForUpdate()` para garantizar atomicidad.

✓ Funciona en MySQL 5.7+, PostgreSQL, y otras BD con soporte ACID.

---

## Fase de Integración (Futuro)

**Esta fase:** Código preparado pero NO integrado.

**Fase 2:** Integración en proceso de apertura de condición.

**Fase 3:** Reutilización del número en cierre de condición.

**Requisito:**
Ejecutar migración antes de usar:
```bash
php artisan migrate
```

---

## Tabla de Contador (`boleta_counters`)

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

**Por qué en tabla separada:**
- Isolate del logicaología de movimientos
- Reutilizable en múltiples contextos
- Evita contaminación del modelo Movimiento
- Facilita auditoría y administración

---

## Notas Importantes

1. **No se ejecutó la migración.** Preparada pero lista para cuando se necesite.

2. **No se modificó:** Formularios, controladores, modelos, procesos actuales.

3. **Independiente:** El servicio es un módulo independiente sin dependencias externas.

4. **Listo para inyección:** Compatible con inyección de dependencias de Laravel.

5. **Concurrente:** Totalmente seguro para ambiente multi-usuario/multi-request.

---

## Próximos Pasos (Cuando se integre)

1. Ejecutar: `php artisan migrate`
2. Inyectar `TicketNumberService` en controlador de movimientos
3. Usar `generateTicketNumber()` al abrir condición
4. Reutilizar el número al cerrar (sin generar nuevo)
5. Ejecutar tests: `php artisan test tests/Unit/Services/TicketNumberServiceTest.php`

---

## Referencia Rápida de Métodos

| Método | Parámetros | Retorna | Thread-safe |
|--------|-----------|---------|-------------|
| `generateTicketNumber()` | - | `string` | ✓ Sí |
| `getNextTicketNumber(?int)` | `year` | `string` | ✓ Sí |
| `getNextSequence(?int)` | `year` | `int` | ✓ Sí |
| `getCounterStats(?int)` | `year` | `array` | ✓ Sí |
| `resetCounterForYear(int, int)` | `year, start` | `bool` | ✓ Sí |
| `isValidFormat(string)` | `ticket` | `bool` | ✓ Sí (estático) |
| `parseTicketNumber(string)` | `ticket` | `array\|null` | ✓ Sí (estático) |

---

## Soporte

Consultar [`TICKET_NUMBER_SYSTEM.md`](./TICKET_NUMBER_SYSTEM.md) para documentación completa con ejemplos de integración.
