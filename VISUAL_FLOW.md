# Diagrama Visual: Flujo de Boletas en AlderX

## Estado Actual (Fase 1)

```
┌─────────────────────────────────────────────────────────────┐
│                      COMPONENTES LISTOS                     │
├─────────────────────────────────────────────────────────────┤
│                                                             │
│  ✓ TicketNumberService.php                                │
│    └─ Lógica de generación (INDEPENDIENTE)                │
│                                                             │
│  ✓ Tabla boleta_counters (PREPARADA, NO EJECUTADA)        │
│    └─ Almacena contadores por año                         │
│                                                             │
│  ✓ Tests (LISTOS)                                          │
│    └─ 11+ casos de validación                             │
│                                                             │
│  ✓ Documentación (COMPLETA)                                │
│    └─ Técnica, guías y arquitectura                        │
│                                                             │
└─────────────────────────────────────────────────────────────┘
              ⬇️
         (NO CONECTADO AÚN)
              ⬇️
┌─────────────────────────────────────────────────────────────┐
│                 CÓDIGO EXISTENTE (SIN CAMBIOS)              │
├─────────────────────────────────────────────────────────────┤
│  • Formularios de movimientos                              │
│  • Controladores                                           │
│  • Tabla movimientos                                       │
│  • Procesos de apertura/cierre                             │
└─────────────────────────────────────────────────────────────┘
```

---

## Estado Futuro (Fase 2 + 3)

```
┌──────────────────────────────────────────────────────────────────┐
│                   USUARIO ABRE CONDICIÓN                         │
└──────────────────────────────────────────────────────────────────┘
                              ⬇️
┌──────────────────────────────────────────────────────────────────┐
│          FORMULARIO APERTURA DE CONDICIÓN                        │
│  (Cargo, contenedor, genset, etc.)                               │
└──────────────────────────────────────────────────────────────────┘
                              ⬇️
┌──────────────────────────────────────────────────────────────────┐
│          CONTROLADOR: AbrirCondicionController                   │
├──────────────────────────────────────────────────────────────────┤
│                                                                  │
│  1. Validar datos del formulario                                │
│                                                                  │
│  2. ✨ GENERAR NÚMERO DE BOLETA                                 │
│     $ticketService->generateTicketNumber()                      │
│     Resultado: "2026-0000001" ⭐                                 │
│                                                                  │
│  3. Crear registro de movimiento                                │
│     Movimiento::create([                                        │
│         'mov_boleta' => "2026-0000001",    ⭐ GENERADA          │
│         'mov_tipomovimiento' => 'salida',                       │
│         'mov_fecha' => now(),                                   │
│         ... otros campos del formulario                         │
│     ]);                                                          │
│                                                                  │
│  4. Responder: Apertura registrada exitosamente                │
│                                                                  │
└──────────────────────────────────────────────────────────────────┘
                              ⬇️
┌──────────────────────────────────────────────────────────────────┐
│                  TABLA MOVIMIENTOS                               │
├──────────────────────────────────────────────────────────────────┤
│  mov_id  │ mov_boleta    │ mov_tipomovimiento │ mov_fecha      │
│  1       │ 2026-0000001  │ salida             │ 2026-11-16     │
│          │               │                    │                │
│          │ 🔵 BOLETA ACTIVA (Contenedor en almacén)             │
│          │               │                    │                │
└──────────────────────────────────────────────────────────────────┘
                              ⬇️
         [TIEMPO TRANSCURRE: Contenedor almacenado]
                              ⬇️
┌──────────────────────────────────────────────────────────────────┐
│                   USUARIO CIERRA CONDICIÓN                       │
│  (Selecciona el movimiento de apertura a cerrar)                │
└──────────────────────────────────────────────────────────────────┘
                              ⬇️
┌──────────────────────────────────────────────────────────────────┐
│         FORMULARIO CIERRE DE CONDICIÓN                           │
│  (Genset, llantas, observaciones, etc.)                          │
└──────────────────────────────────────────────────────────────────┘
                              ⬇️
┌──────────────────────────────────────────────────────────────────┐
│          CONTROLADOR: CerrarCondicionController                  │
├──────────────────────────────────────────────────────────────────┤
│                                                                  │
│  1. Obtener datos del movimiento de apertura                    │
│     $movimientoApertura = Movimiento::find($id);                │
│     $boleta = $movimientoApertura->mov_boleta;                  │
│     // Resultado: "2026-0000001"                                │
│                                                                  │
│  2. ⭐ REUTILIZAR BOLETA (NO generar nueva)                     │
│     // La boleta se reutiliza directamente                      │
│                                                                  │
│  3. Crear registro de cierre con la MISMA boleta                │
│     Movimiento::create([                                        │
│         'mov_boleta' => "2026-0000001",    ⭐ REUTILIZADA       │
│         'mov_tipomovimiento' => 'ingreso',                      │
│         'mov_fecha' => now(),                                   │
│         ... otros campos del formulario                         │
│     ]);                                                          │
│                                                                  │
│  4. Responder: Cierre registrado exitosamente                   │
│                                                                  │
└──────────────────────────────────────────────────────────────────┘
                              ⬇️
┌──────────────────────────────────────────────────────────────────┐
│                  TABLA MOVIMIENTOS                               │
├──────────────────────────────────────────────────────────────────┤
│  mov_id  │ mov_boleta    │ mov_tipomovimiento │ mov_fecha      │
│  1       │ 2026-0000001  │ salida             │ 2026-11-16     │
│  2       │ 2026-0000001  │ ingreso            │ 2026-11-17     │
│          │                                                       │
│          │ 🟢 BOLETA CERRADA (dos movimientos)                  │
│          │    - Apertura + Cierre = Ciclo completo              │
│          │                                                       │
└──────────────────────────────────────────────────────────────────┘
                              ⬇️
           [LISTO PARA NUEVO CICLO]
                              ⬇️
┌──────────────────────────────────────────────────────────────────┐
│          SIGUIENTE BOLETA: "2026-0000002"                        │
│          (El contador se incrementó automáticamente)             │
└──────────────────────────────────────────────────────────────────┘
```

---

## Garantía de Concurrencia en Tiempo Real

```
Escenario: Dos usuarios abren condición simultáneamente

Tiempo    Usuario A                 TicketNumberService      Usuario B
─────────────────────────────────────────────────────────────────────
   0      Solicita boleta ─────────────────┐
                                           ├─ DB::transaction()
          (Usuario B también)   ───────────┤  iniciada
                                           │
   5      (Espera)                 SELECT ... FOR UPDATE
                                   └─► Obtiene bloqueo
                                   
  10      (Usuario B espera)      Generar "2026-0000001"
                                  UPDATE next_sequence=2
                                  COMMIT (libera bloqueo)
                                  └─► DEVUELVE a Usuario A
                                  
  15      Recibe "2026-0000001" ◀──────┐
          Crea movimiento               │ Usuario B ahora obtiene bloqueo
                                        │
  20      (Usuario B adquiere)   SELECT ... FOR UPDATE
                                        │ Generar "2026-0000002"
                                        │ UPDATE next_sequence=3
                                        │ COMMIT
                                        └─► DEVUELVE a Usuario B
                                        
  25      Movimiento creado ✓   Recibe "2026-0000002" ◀──┐
          Boleta: 2026-0000001  Crea movimiento         │
                                 Boleta: 2026-0000002 ◀─┘
                                 
  30                            ✅ GARANTIZADO: Sin duplicados
                                   Sin race conditions
                                   Orden secuencial
```

---

## Contador en Base de Datos

```
Durante el día 16 de Noviembre 2026:

Hora 08:00
  boleta_counters:
  ┌──────┬────────┬───────────────┐
  │ year │ seq    │ estado        │
  ├──────┼────────┼───────────────┤
  │ 2026 │ 1      │ Inicial       │
  └──────┴────────┴───────────────┘

Hora 10:30 (después de 42 aperturas)
  boleta_counters:
  ┌──────┬────────┬───────────────┐
  │ year │ seq    │ estado        │
  ├──────┼────────┼───────────────┤
  │ 2026 │ 43     │ Próxima: 043  │
  └──────┴────────┴───────────────┘

Hora 23:59 (fin de año)
  boleta_counters:
  ┌──────┬────────┬───────────────────┐
  │ year │ seq    │ estado            │
  ├──────┼────────┼───────────────────┤
  │ 2026 │ 8542   │ Cierre de año     │
  │ 2027 │ 1      │ Listo para nuevo  │
  └──────┴────────┴───────────────────┘
  
  Resultado:
  - 2026: 8541 boletas generadas
  - 2027: Contador reiniciado automáticamente
  - Próxima boleta: 2027-0000001
```

---

## Integración de Componentes (Fase 2+3)

```
app/
├── Http/
│   └── Controllers/
│       ├── AbrirCondicionController.php        ⭐ [FASE 2]
│       │   └── use TicketNumberService
│       │   └── generateTicketNumber()
│       │
│       └── CerrarCondicionController.php       ⭐ [FASE 3]
│           └── use TicketNumberService
│           └── Reutilizar $boleta (sin generar)
│
├── Models/
│   └── Movimiento.php                          ⭐ [FASE 2]
│       └── mov_boleta: string
│       └── mov_tipomovimiento: enum ('salida'|'ingreso')
│
└── Services/
    └── TicketNumberService.php                 ✓ [FASE 1 - LISTO]
        └── Independiente y reutilizable
```

---

## Reutilización de Número (Mecanismo)

```
Movimiento de Apertura (Guardado en BD)
┌────────────────────────────────────┐
│ mov_id: 1                          │
│ mov_boleta: "2026-0000001"  ◀──┐   │
│ mov_tipomovimiento: "salida" │   │
│ mov_fecha: 2026-11-16        │   │
└────────────────────────────────────┘
                                 │
                                 │
                    (Lectura en Fase 3)
                                 │
                                 ▼
        $boleta = $apertura->mov_boleta
        // "2026-0000001"
                                 │
                                 ▼
Movimiento de Cierre (Nuevo registro)
┌────────────────────────────────────┐
│ mov_id: 2                          │
│ mov_boleta: "2026-0000001"  ◀─────┘ REUTILIZADO
│ mov_tipomovimiento: "ingreso"      (NO generado)
│ mov_fecha: 2026-11-17             │
└────────────────────────────────────┘

VENTAJA: Una boleta vincula apertura y cierre
GARANTÍA: No se genera número duplicado
```

---

## Validación de Formato (Estática)

```
Entrada: "2026-0000001"
         ││││││││││││
         ││││││││││││
         ││││││││││└─ 1-7: Correlativo (7 dígitos)
         ││││││││└──── Separador: "-"
         └││││││└───── 1-4: Año (4 dígitos)
          └────────────── Obligatorio


Validaciones automáticas:
✓ Formato: AAAA-CCCCCCC
✓ Año: 4 dígitos numéricos
✓ Separador: guión (-)
✓ Correlativo: 7 dígitos numéricos
✓ Rango correlativo: 0000000 → 9999999

Rechazo automático:
✗ "2026-123" - Correlativo muy corto
✗ "26-0000001" - Año de 2 dígitos
✗ "2026/0000001" - Separador incorrecto
✗ "ABC-0000001" - Año no numérico
✗ "" - Vacío
```

---

## Métricas Esperadas en Producción

```
Supuestos:
- 2 recintos
- 8 horas operativas/día
- 20 movimientos/hora/recinto

Cálculos:
  Movimientos/día = 2 recintos × 8h × 20 = 320 movimientos
  Movimientos/año = 320 × 250 días hábiles = 80,000
  
  Boletas/año = 80,000 (una por apertura)
  Consumo: 0.8% de capacidad (máx: 10,000,000)
  
Margen de seguridad: 125x
Crecimiento permitido: 125 años a tasa actual
```

---

## Estado Resumen

```
┌─────────────────────────────────────────────────────────────┐
│                                                             │
│  FASE 1: ✅ COMPLETADA                                     │
│  ├─ Código: ✓ Creado y documentado                         │
│  ├─ Migraciones: ✓ Preparadas (no ejecutadas)              │
│  ├─ Tests: ✓ Listos                                        │
│  └─ Documentación: ✓ Completa                              │
│                                                             │
│  FASE 2: ⏳ PENDIENTE (Cuando se requiera)                 │
│  ├─ Ejecutar migración                                     │
│  ├─ Crear controlador de apertura                          │
│  └─ Integrar servicio en apertura                          │
│                                                             │
│  FASE 3: ⏳ PENDIENTE (Cuando se requiera)                 │
│  ├─ Crear controlador de cierre                            │
│  └─ Implementar reutilización de números                   │
│                                                             │
│  CÓDIGO EXISTENTE: ✓ SIN CAMBIOS                           │
│                                                             │
└─────────────────────────────────────────────────────────────┘
```
