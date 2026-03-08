<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Departamentos;
use Illuminate\Support\Facades\Hash;

class DepartamentosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Departamentos::create([
            'dep_nombre' => 'Gerencia',
        ]);

        Departamentos::create([
            'dep_nombre' => 'Administración',
        ]);

        Departamentos::create([
            'dep_nombre' => 'Interchange',
        ]);

    }
}