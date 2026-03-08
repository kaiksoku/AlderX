<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class RecintoSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('recintos')->insert([
            [
                'reci_nombre' => 'Puerto Barrios',
                'reci_descripcion' => 'Recinto Puerto Barrios',
                'reci_activo' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'reci_nombre' => 'Escuintla',
                'reci_descripcion' => 'Recinto Escuintla',
                'reci_activo' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'reci_nombre' => 'Arizona',
                'reci_descripcion' => 'Recinto Arizona',
                'reci_activo' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
