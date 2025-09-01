<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProveedoresTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('proveedores')->insert([
            ['ProveedorId' => 1, 'Nombre' => 'Arca Continental', 'Estado' => 1, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
