<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Inserta un usuario admin
        DB::table('users')->insert([
            'username' => 'test',
            'password' => Hash::make('123'),
            'clock_number' => '40023',
            'role' => 'tecnico',
            'position' => 'Técnico de Mantenimiento',
            'status' => 'activo', // Agrega el estado del usuario
        ]);
    }
}
