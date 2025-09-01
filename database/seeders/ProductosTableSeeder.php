<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('productos')->insert([
            [
                'ProductoId' => 9,
                'Nombre' => 'Pony Malta',
                'Descripcion' => 'Bebida a base de malta',
                'Precio' => 1.00,
                'Stock' => 500,
                'Imagen' => 'https://res.cloudinary.com/alwaysdev/image/upload/v1752614158/the_owl/phpF49F_gvnmjd.jpg',
                'Creado' => '2025-07-15 21:15:58',
                'CategoriaId' => 2,
                'ProveedorId' => null,
                'MarcaId' => null,
                'TamanoId' => null,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'ProductoId' => 10,
                'Nombre' => 'Pony Malta Lata',
                'Descripcion' => 'Pony Malta en lata',
                'Precio' => 1.00,
                'Stock' => 500,
                'Imagen' => 'https://res.cloudinary.com/alwaysdev/image/upload/v1752802067/the_owl/php173E_mk3aly.webp',
                'Creado' => '2025-07-18 01:27:46',
                'CategoriaId' => 2,
                'ProveedorId' => null,
                'MarcaId' => null,
                'TamanoId' => null,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'ProductoId' => 11,
                'Nombre' => 'Cocacola',
                'Descripcion' => 'Cocola de 1lts',
                'Precio' => 2.00,
                'Stock' => 200,
                'Imagen' => 'https://res.cloudinary.com/alwaysdev/image/upload/v1753307770/the_owl/phpE07B_i3hvys.webp',
                'Creado' => '2025-07-23 21:56:10',
                'CategoriaId' => 9,
                'ProveedorId' => null,
                'MarcaId' => null,
                'TamanoId' => null,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'ProductoId' => 13,
                'Nombre' => 'Gatorade',
                'Descripcion' => 'Gatorade de 750ml',
                'Precio' => 2.00,
                'Stock' => 500,
                'Imagen' => 'https://res.cloudinary.com/alwaysdev/image/upload/v1753418512/the_owl/php9DCE_k6h7q3.png',
                'Creado' => '2025-07-25 04:41:53',
                'CategoriaId' => 2,
                'ProveedorId' => null,
                'MarcaId' => null,
                'TamanoId' => null,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'ProductoId' => 15,
                'Nombre' => 'Powerade',
                'Descripcion' => 'Tamaño 375ml',
                'Precio' => 1.00,
                'Stock' => 500,
                'Imagen' => 'https://res.cloudinary.com/alwaysdev/image/upload/v1753476447/the_owl/php295A_fa2unm.webp',
                'Creado' => '2025-07-25 20:47:27',
                'CategoriaId' => 8,
                'ProveedorId' => null,
                'MarcaId' => null,
                'TamanoId' => null,
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);
    }
}
