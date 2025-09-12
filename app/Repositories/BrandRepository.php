<?php

namespace App\Repositories;

use App\Interfaces\BrandRepositoryInterface;
use App\Models\Brand;
use Illuminate\Database\Eloquent\Collection;
use function _PHPStan_781aefaf6\React\Promise\all;

class BrandRepository implements BrandRepositoryInterface
{
    protected $model;

    public function __construct(Brand $model)
    {
        $this->model = $model;
    }

    public function getAll(): Collection
    {

        return $this->model
            ->select([
                'MarcaId',
                'Nombre',
                'Estado'
            ])
            ->get();
    }

    public function getById(int $id): ?Brand
    {
        return $this->model->find($id);
    }

    public function create(array $data): Brand
    {
        return $this->model->create([
            'Nombre' => $data['Nombre'],
            'Estado' => $data['Estado'] ?? 1
        ]);
    }

    public function update(int $id, array $data): bool
    {
        $brand = $this->model->find($id);

        if (!$brand) {
            return false;
        }

        return $brand->update([
            'Nombre' => $data['Nombre'],
            'Estado' => $data['Estado']
        ]);
    }

    public function delete(int $id): bool
    {
        $brand = $this->model->find($id);

        if (!$brand) {
            return false;
        }


        return $brand->update(['Estado' => 0]);
    }

    public function assignSize($sizeId, $state = true): bool
    {
        return $this->model->assignSize($sizeId, $state);
    }

    public function updateSizeStatus($sizeId, $state): bool
    {
        return $this->model->updateSizeStatus($sizeId, $state);
    }

    
}
