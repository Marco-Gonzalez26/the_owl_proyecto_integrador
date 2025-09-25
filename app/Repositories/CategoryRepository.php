<?php

namespace App\Repositories;

use App\Interfaces\CategoryRepositoryInterface;
use App\Models\Category;
use Illuminate\Database\Eloquent\Collection;


class CategoryRepository implements CategoryRepositoryInterface
{
    protected $model;

    public function __construct(Category $model)
    {
        $this->model = $model;
    }

    public function getAll(): Collection
    {
        return $this->model
            ->select([
                'CategoriaId',
                'Nombre',
                'Estado'
            ])
            ->get();
    }

    public function getById(int $id): ?Category
    {
        return $this->model
            ->find($id);
    }

    public function create(array $data): Category
    {
        // Laravel automáticamente valida y sanitiza
        return $this->model->create([
            'Nombre' => $data['Nombre'],
            'Estado' => $data['Estado']
        ]);
    }

    public function update(int $id, array $data): bool
    {
        $category = $this->model->find($id);

        if (!$category) {
            return false;
        }

        return $category->update([
            'CategoriaId' => $id,
            'Nombre' => $data['name'],
            'Estado' => $data['state']
        ]);
    }

    public function delete(int $id): bool
    {
        $category = $this->model->find($id);

        if (!$category) {
            return false;
        }

        return $category->update(["CategoriaId" => $id, "Estado" => 0]);
    }
}
