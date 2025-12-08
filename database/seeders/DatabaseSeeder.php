<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $password = bcrypt('senac123');

        // Primeiro usuário é admin
        User::create(['name' => 'Matheus', 'email' => 'matheus@example.com', 'password' => $password, 'is_admin' => true]);
        
        // Demais usuários são regulares
        User::create(['name' => 'Felipe', 'email' => 'felipe@example.com', 'password' => $password]);
        User::create(['name' => 'Arthur', 'email' => 'arthur@example.com', 'password' => $password]);
        User::create(['name' => 'Wanessa', 'email' => 'wanessa@example.com', 'password' => $password]);
        User::create(['name' => 'Julia', 'email' => 'julia@example.com', 'password' => $password]);
        User::create(['name' => 'Wesley', 'email' => 'wesley@example.com', 'password' => $password]);
        User::create(['name' => 'Claudio', 'email' => 'claudio@example.com', 'password' => $password]);

        $this->call(ProductSeeder::class);
    }
}
