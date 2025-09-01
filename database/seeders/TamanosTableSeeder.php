<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TamanosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('tamanos')->insert([
            ['TamanoId' => 2, 'Descripcion' => '1lts', 'created_at' => now(), 'updated_at' => now()],
            ['TamanoId' => 3, 'Descripcion' => '375ml', 'created_at' => now(), 'updated_at' => now()],
            ['TamanoId' => 4, 'Descripcion' => '1lts', 'created_at' => now(), 'updated_at' => now()],
            ['TamanoId' => 5, 'Descripcion' => '500ml', 'created_at' => now(), 'updated_at' => now()],
            ['TamanoId' => 6, 'Descripcion' => '375ml', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
