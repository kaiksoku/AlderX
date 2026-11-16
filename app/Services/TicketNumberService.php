<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Exception;

/**
 * Servicio para la generación y administración de números de boleta.
 * 
 * Formato: AAAA-CCCCCCC
 * Ejemplo: 2026-0000001
 * 
 * - AAAA: Año de emisión (4 dígitos)
 * - CCCCCCC: Correlativo (7 dígitos, reinicia cada año)
 * - Numeración compartida entre todos los recintos
 * - Generación segura ante solicitudes simultáneas
 */
class TicketNumberService
{
    /**
     * Nombre de la tabla que almacena el contador de boletas
     */
    private const COUNTER_TABLE = 'boleta_counters';

    /**
     * Genera un nuevo número de boleta seguro ante concurrencia.
     * 
     * @return string Número de boleta en formato AAAA-CCCCCCC
     * @throws Exception Si ocurre un error durante la generación
     */
    public function generateTicketNumber(): string
    {
        try {
            return DB::transaction(function () {
                $currentYear = Carbon::now()->year;
                
                // Obtiene o crea el registro del contador para el año actual
                $counter = DB::table(self::COUNTER_TABLE)
                    ->lockForUpdate()
                    ->where('year', $currentYear)
                    ->first();

                if (!$counter) {
                    // Inserta un nuevo contador para el año actual
                    DB::table(self::COUNTER_TABLE)->insert([
                        'year' => $currentYear,
                        'next_sequence' => 1,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                    
                    $nextSequence = 1;
                } else {
                    $nextSequence = $counter->next_sequence;
                }

                // Genera el número de boleta
                $ticketNumber = $this->formatTicketNumber($currentYear, $nextSequence);

                // Incrementa el contador
                DB::table(self::COUNTER_TABLE)
                    ->where('year', $currentYear)
                    ->update([
                        'next_sequence' => $nextSequence + 1,
                        'updated_at' => now(),
                    ]);

                return $ticketNumber;
            });
        } catch (Exception $e) {
            throw new Exception("Error al generar número de boleta: " . $e->getMessage());
        }
    }

    /**
     * Formatea un número de boleta con el patrón AAAA-CCCCCCC.
     * 
     * @param int $year Año en formato 4 dígitos
     * @param int $sequence Número secuencial
     * @return string Número de boleta formateado
     */
    private function formatTicketNumber(int $year, int $sequence): string
    {
        return sprintf("%04d-%07d", $year, $sequence);
    }

    /**
     * Obtiene el próximo número secuencial para un año específico
     * sin incrementarlo.
     * 
     * @param int $year Año a consultar (si es null, usa año actual)
     * @return int Próximo número secuencial
     */
    public function getNextSequence(?int $year = null): int
    {
        if ($year === null) {
            $year = Carbon::now()->year;
        }

        $counter = DB::table(self::COUNTER_TABLE)
            ->where('year', $year)
            ->first();

        return $counter ? $counter->next_sequence : 1;
    }

    /**
     * Obtiene el número de boleta que se generaría a continuación.
     * Este método es útil para previsualizaciones y no incrementa el contador.
     * 
     * @param int $year Año a consultar (si es null, usa año actual)
     * @return string Número de boleta que se generaría a continuación
     */
    public function getNextTicketNumber(?int $year = null): string
    {
        if ($year === null) {
            $year = Carbon::now()->year;
        }

        $sequence = $this->getNextSequence($year);
        return $this->formatTicketNumber($year, $sequence);
    }

    /**
     * Reinicia el contador para un año específico.
     * Útil para correcciones administrativas.
     * 
     * @param int $year Año a reiniciar
     * @param int $startSequence Número secuencial inicial (por defecto 1)
     * @return bool True si se reinició correctamente
     */
    public function resetCounterForYear(int $year, int $startSequence = 1): bool
    {
        try {
            DB::table(self::COUNTER_TABLE)
                ->where('year', $year)
                ->update([
                    'next_sequence' => $startSequence,
                    'updated_at' => now(),
                ]);

            return true;
        } catch (Exception $e) {
            throw new Exception("Error al reiniciar contador: " . $e->getMessage());
        }
    }

    /**
     * Obtiene estadísticas del contador para un año específico.
     * 
     * @param int $year Año a consultar (si es null, usa año actual)
     * @return array Información del contador
     */
    public function getCounterStats(?int $year = null): array
    {
        if ($year === null) {
            $year = Carbon::now()->year;
        }

        $counter = DB::table(self::COUNTER_TABLE)
            ->where('year', $year)
            ->first();

        if (!$counter) {
            return [
                'year' => $year,
                'next_sequence' => 1,
                'total_generated' => 0,
                'exists' => false,
            ];
        }

        return [
            'year' => $year,
            'next_sequence' => $counter->next_sequence,
            'total_generated' => $counter->next_sequence - 1,
            'exists' => true,
            'created_at' => $counter->created_at,
            'updated_at' => $counter->updated_at,
        ];
    }

    /**
     * Verifica si un número de boleta tiene el formato correcto.
     * 
     * @param string $ticketNumber Número de boleta a validar
     * @return bool True si el formato es válido
     */
    public static function isValidFormat(string $ticketNumber): bool
    {
        return preg_match('/^\d{4}-\d{7}$/', $ticketNumber) === 1;
    }

    /**
     * Extrae el año y el correlativo de un número de boleta.
     * 
     * @param string $ticketNumber Número de boleta
     * @return array|null Array con 'year' y 'sequence', o null si no es válido
     */
    public static function parseTicketNumber(string $ticketNumber): ?array
    {
        if (!self::isValidFormat($ticketNumber)) {
            return null;
        }

        [$year, $sequence] = explode('-', $ticketNumber);

        return [
            'year' => (int) $year,
            'sequence' => (int) $sequence,
        ];
    }
}
