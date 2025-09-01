<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('categorias')->insert([
            ['CategoriaId' => 1, 'Nombre' => 'Alimentos', 'Estado' => 0, 'created_at' => now(), 'updated_at' => now()],
            ['CategoriaId' => 2, 'Nombre' => 'Bebidas', 'Estado' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['CategoriaId' => 3, 'Nombre' => 'Bebidas Alcohólicas', 'Estado' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['CategoriaId' => 7, 'Nombre' => 'Dulces', 'Estado' => 0, 'created_at' => now(), 'updated_at' => now()],
            ['CategoriaId' => 8, 'Nombre' => 'Bebidas Energéticas', 'Estado' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['CategoriaId' => 9, 'Nombre' => 'Bebidas Azucaradas', 'Estado' => 1, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
