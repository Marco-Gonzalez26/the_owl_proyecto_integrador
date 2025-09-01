<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            RolesTableSeeder::class,
            UsuariosTableSeeder::class,
            CategoriasTableSeeder::class,
            MarcasTableSeeder::class,
            TamanosTableSeeder::class,
            ProveedoresTableSeeder::class,
            ProductosTableSeeder::class,
            MarcaTamanoTableSeeder::class,
        ]);
    }
}
