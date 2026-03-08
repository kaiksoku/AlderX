<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Restaurantes;
use Illuminate\Support\Facades\Hash;

class RestaurantesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Restaurantes::create([
            'rest_nombre' => 'Maxim',
            'rest_correo' => 'contacto@maxim.com',
            'rest_horarios' => 'Almuerzo - Cena',
        ]);

        Restaurantes::create([
            'rest_nombre' => 'Mr. Wok',
            'rest_correo' => 'reservas@mrwok.com',
            'rest_horarios' => 'Almuerzo - Cena',
        ]);

        Restaurantes::create([
            'rest_nombre' => 'Miramar',
            'rest_correo' => 'info@miramar.com',
            'rest_horarios' => 'Los 3 Tiempos',
        ]);

        Restaurantes::create([
            'rest_nombre' => 'Safari',
            'rest_correo' => 'contacto@safari.com',
            'rest_horarios' => 'Los 3 Tiempos',
        ]);

        Restaurantes::create([
            'rest_nombre' => 'Mar y Tierra',
            'rest_correo' => 'contacto@marytierra.com',
            'rest_horarios' => 'Desayuno - Almuerzo',
        ]);
    }
}
