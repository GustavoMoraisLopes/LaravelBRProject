<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Produto;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Criar Admin por defeito
        User::create([
            'name' => 'Administrador',
            'email' => 'admin@tuguinha.pt',
            'password' => bcrypt('123456'),
            'is_admin' => true,
        ]);

        // Criar um utilizador normal de exemplo
        User::create([
            'name' => 'Utilizador Normal',
            'email' => 'user@tuguinha.pt',
            'password' => bcrypt('admin@tuguinha.pt'),
            'is_admin' => false,
        ]);

        // Exemplo: adicionar produtos (opcional)
        Produto::factory(3)->create();
    }
}
