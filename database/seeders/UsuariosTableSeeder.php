<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsuariosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('usuarios')->insert([
            [
                'id' => 2,
                'nombre_usuario' => 'the_owl_admin',
                'contrasena' => '$2y$10$k31uLatl64zYtckYd7m09uM5GRNZp8DOX8JGEWH4y9IqB/WO7mMdW',
                'rol' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);
    }
}
