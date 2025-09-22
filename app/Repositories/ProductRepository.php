<?php

namespace App\Repositories;

use App\Interfaces\ProductRepositoryInterface;
use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;

class ProductRepository implements ProductRepositoryInterface
{
    protected $model;

    public function __construct(Product $model)
    {
        $this->model = $model;
    }

    public function getAll(): Collection
    {
        return $this->model
            ->with('categoria:CategoriaId,Nombre')
            ->select([
                'ProductoId',
                'Nombre',
                'Descripcion',
                'Precio',
                'Stock',
                'Imagen',
                'CategoriaId'
            ])
            ->get()
            ->map(function ($product) {
                $product->NombreCategoria = $product->categoria->Nombre ?? '';
                return $product;
            });
    }

    public function getById(int $id): ?Product
    {
        return $this->model
            ->with('categoria:CategoriaId,Nombre')
            ->find($id);
    }

    public function create(array $data): Product
    {

        return $this->model->create([
            'Nombre' => $data['Nombre'],
            'Descripcion' => $data['Descripcion'],
            'Precio' => $data['Precio'],
            'Stock' => $data['Stock'],
            'Imagen' => $data['Imagen'],
            'CategoriaId' => $data['CategoriaId']
        ]);
    }

    public function update(int $id, array $data): bool
    {
        $product = $this->model->find($id);

        if (!$product) {
            return false;
        }

        return $product->update([
            'Nombre' => $data['Nombre'],
            'Descripcion' => $data['Descripcion'],
            'Precio' => $data['Precio'],
            'Stock' => $data['Stock'],
            'Imagen' => $data['Imagen'],
            'CategoriaId' => $data['CategoriaId']
        ]);
    }

    public function delete(int $id): bool
    {
        $product = $this->model->find($id);

        if (!$product) {
            return false;
        }

        return $product->delete();
    }

    public function decrementStock(int $id, int $quantity): bool
    {
        $product = $this->model->find($id);

        if (!$product) {
            return false;
        }

        $product->Stock -= $quantity;

        return $product->save();
    }
}
