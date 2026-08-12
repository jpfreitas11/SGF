<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\Department;
use App\Models\Position;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;


class SgfSeeder extends Seeder
{
   
    public function run(): void
    {
              User::create([
            'name' => 'Super Admin',
            'email' => 'super@sgf.test',
            'password' => Hash::make('password'),
            'role' => UserRole::SuperAdmin,
        ]);

        Position::create(['title' => 'Estagiario', 'level' => 10]);
        Position::create(['title' => 'Analista', 'level' => 20]);
        Position::create(['title' => 'Coordenador', 'level' => 30]);
        Position::create(['title' => 'Gerente', 'level' => 40]);

        Department::create(['name' => 'Tecnologia']);
        Department::create(['name' => 'Financeiro']);
    }
}
