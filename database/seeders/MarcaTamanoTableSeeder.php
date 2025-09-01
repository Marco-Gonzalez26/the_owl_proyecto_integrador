<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MarcaTamanoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
                DB::table('marca_tamano')->insert([
            ['MarcaId' => 5, 'TamanoId' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['MarcaId' => 5, 'TamanoId' => 3, 'created_at' => now(), 'updated_at' => now()],
            ['MarcaId' => 6, 'TamanoId' => 4, 'created_at' => now(), 'updated_at' => now()],
            ['MarcaId' => 6, 'TamanoId' => 5, 'created_at' => now(), 'updated_at' => now()],
            ['MarcaId' => 6, 'TamanoId' => 6, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
