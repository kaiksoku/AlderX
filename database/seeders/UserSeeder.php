<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    { 
        User::create([
            'name' => 'Bryan Moreno',
            'email' => 'Kaiksoku@gmail.com',
            'password' => bcrypt('Kaiksoku2328'), 
            'departamento' => 3,
            'recinto' => 1,
        ])->assignRole('Admin');
    }
}
