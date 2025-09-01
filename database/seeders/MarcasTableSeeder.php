<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MarcasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('marcas')->insert([
            ['MarcaId' => 5, 'Nombre' => 'Cocacola', 'Estado' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['MarcaId' => 6, 'Nombre' => 'Gatorade', 'Estado' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['MarcaId' => 7, 'Nombre' => 'Sporade', 'Estado' => 1, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
