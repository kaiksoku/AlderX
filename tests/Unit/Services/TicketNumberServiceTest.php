<?php

namespace Tests\Unit\Services;

use App\Services\TicketNumberService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TicketNumberServiceTest extends TestCase
{
    use RefreshDatabase;

    private TicketNumberService $ticketService;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Ejecutar la migración de la tabla boleta_counters
        $this->artisan('migrate', ['--database' => 'testing']);
        
        $this->ticketService = new TicketNumberService();
    }

    /**
     * Test: Formato de validación de boleta
     */
    public function test_valid_ticket_number_format()
    {
        $this->assertTrue(TicketNumberService::isValidFormat('2026-0000001'));
        $this->assertTrue(TicketNumberService::isValidFormat('2025-9999999'));
        $this->assertTrue(TicketNumberService::isValidFormat('2000-0000000'));
    }

    /**
     * Test: Rechazo de formatos inválidos
     */
    public function test_invalid_ticket_number_format()
    {
        $this->assertFalse(TicketNumberService::isValidFormat('2026-123'));          // Correlativo muy corto
        $this->assertFalse(TicketNumberService::isValidFormat('26-0000001'));        // Año de 2 dígitos
        $this->assertFalse(TicketNumberService::isValidFormat('2026/0000001'));      // Separador incorrecto
        $this->assertFalse(TicketNumberService::isValidFormat('invalid'));            // Sin formato
        $this->assertFalse(TicketNumberService::isValidFormat(''));                   // Vacío
    }

    /**
     * Test: Parsing de números de boleta
     */
    public function test_parse_ticket_number()
    {
        $parsed = TicketNumberService::parseTicketNumber('2026-0000001');
        $this->assertIsArray($parsed);
        $this->assertEquals(2026, $parsed['year']);
        $this->assertEquals(1, $parsed['sequence']);

        $parsed = TicketNumberService::parseTicketNumber('2025-9999999');
        $this->assertEquals(2025, $parsed['year']);
        $this->assertEquals(9999999, $parsed['sequence']);
    }

    /**
     * Test: Rechazo de parsing con formato inválido
     */
    public function test_parse_invalid_ticket_number_returns_null()
    {
        $this->assertNull(TicketNumberService::parseTicketNumber('invalid'));
        $this->assertNull(TicketNumberService::parseTicketNumber('2026-123'));
    }

    /**
     * Test: Generación de primer número de boleta
     */
    public function test_first_ticket_number_generation()
    {
        $ticketNumber = $this->ticketService->generateTicketNumber();
        
        $this->assertTrue(TicketNumberService::isValidFormat($ticketNumber));
        
        $parsed = TicketNumberService::parseTicketNumber($ticketNumber);
        $this->assertEquals(now()->year, $parsed['year']);
        $this->assertEquals(1, $parsed['sequence']);
    }

    /**
     * Test: Generación secuencial de números
     */
    public function test_sequential_ticket_generation()
    {
        $ticket1 = $this->ticketService->generateTicketNumber();
        $ticket2 = $this->ticketService->generateTicketNumber();
        $ticket3 = $this->ticketService->generateTicketNumber();

        $parsed1 = TicketNumberService::parseTicketNumber($ticket1);
        $parsed2 = TicketNumberService::parseTicketNumber($ticket2);
        $parsed3 = TicketNumberService::parseTicketNumber($ticket3);

        $this->assertEquals(1, $parsed1['sequence']);
        $this->assertEquals(2, $parsed2['sequence']);
        $this->assertEquals(3, $parsed3['sequence']);
    }

    /**
     * Test: Obtener próximo número sin incrementar
     */
    public function test_get_next_ticket_without_incrementing()
    {
        $this->ticketService->generateTicketNumber(); // 1
        $this->ticketService->generateTicketNumber(); // 2

        $nextTicket = $this->ticketService->getNextTicketNumber();
        $parsed = TicketNumberService::parseTicketNumber($nextTicket);
        
        $this->assertEquals(3, $parsed['sequence']);

        // Verificar que no se incrementó
        $nextTicket2 = $this->ticketService->getNextTicketNumber();
        $this->assertEquals($nextTicket, $nextTicket2);
    }

    /**
     * Test: Obtener estadísticas del contador
     */
    public function test_get_counter_statistics()
    {
        $this->ticketService->generateTicketNumber();
        $this->ticketService->generateTicketNumber();
        $this->ticketService->generateTicketNumber();

        $stats = $this->ticketService->getCounterStats();

        $this->assertEquals(now()->year, $stats['year']);
        $this->assertEquals(4, $stats['next_sequence']);
        $this->assertEquals(3, $stats['total_generated']);
        $this->assertTrue($stats['exists']);
    }

    /**
     * Test: Contador para año que no existe
     */
    public function test_counter_stats_for_nonexistent_year()
    {
        $stats = $this->ticketService->getCounterStats(2000);

        $this->assertEquals(2000, $stats['year']);
        $this->assertEquals(1, $stats['next_sequence']);
        $this->assertEquals(0, $stats['total_generated']);
        $this->assertFalse($stats['exists']);
    }

    /**
     * Test: Reiniciar contador
     */
    public function test_reset_counter()
    {
        $this->ticketService->generateTicketNumber();
        $this->ticketService->generateTicketNumber();

        $this->ticketService->resetCounterForYear(now()->year, 100);

        $nextTicket = $this->ticketService->getNextTicketNumber();
        $parsed = TicketNumberService::parseTicketNumber($nextTicket);

        $this->assertEquals(100, $parsed['sequence']);
    }

    /**
     * Test: Concurrencia (simulada con múltiples generaciones)
     * 
     * Nota: Para un test real de concurrencia, usar un framework como
     * Apache JMeter o similar que pueda ejecutar peticiones simultáneas.
     */
    public function test_concurrent_generation_sequence()
    {
        $tickets = [];
        for ($i = 0; $i < 10; $i++) {
            $tickets[] = $this->ticketService->generateTicketNumber();
        }

        // Verificar que todos los tickets son únicos
        $this->assertCount(10, array_unique($tickets));

        // Verificar que están en orden secuencial
        for ($i = 0; $i < 10; $i++) {
            $parsed = TicketNumberService::parseTicketNumber($tickets[$i]);
            $this->assertEquals($i + 1, $parsed['sequence']);
        }
    }

    /**
     * Test: Diferentes años tienen contadores separados
     */
    public function test_different_years_have_separate_counters()
    {
        $this->ticketService->generateTicketNumber();
        
        $stats2026 = $this->ticketService->getCounterStats(now()->year);
        $stats2025 = $this->ticketService->getCounterStats(now()->year - 1);

        $this->assertEquals(2, $stats2026['next_sequence']);
        $this->assertEquals(1, $stats2025['next_sequence']);
    }

    /**
     * Test: Verificar que el contador persiste entre instancias
     */
    public function test_counter_persistence_between_instances()
    {
        $service1 = new TicketNumberService();
        $ticket1 = $service1->generateTicketNumber();

        $service2 = new TicketNumberService();
        $ticket2 = $service2->generateTicketNumber();

        $parsed1 = TicketNumberService::parseTicketNumber($ticket1);
        $parsed2 = TicketNumberService::parseTicketNumber($ticket2);

        $this->assertEquals(1, $parsed1['sequence']);
        $this->assertEquals(2, $parsed2['sequence']);
    }
}
