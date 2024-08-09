<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(RoleSeeder::class);
        User::create([
            'name' => 'Test User',
            'username' => 'testuser', // Añade el username aquí
            'email' => 'test@example.com',
            'password' => '12345', // Puedes cambiar 'password' a lo que desees
        ])->assignRole('VISUALIZADOR');
    }
}
