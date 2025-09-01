<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
     DB::table('roles')->insert([
            ['id' => 1, 'nombre' => 'administrador', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 2, 'nombre' => 'trabajador', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
