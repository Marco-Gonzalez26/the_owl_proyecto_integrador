<?php

namespace App\Repositories;

use App\Interfaces\BrandSizeRepositoryInterface;
use App\Models\BrandSize;
use Illuminate\Database\Eloquent\Collection;

class BrandSizeRepository implements BrandSizeRepositoryInterface
{
    protected $model;

    public function __construct(BrandSize $model)
    {
        $this->model = $model;
    }

    public function getAll(): Collection
    {
        return $this->model
            ->with(['brand:MarcaId,Nombre', 'size:TamanoId,Descripcion,UnidadMedida,Valor'])
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($brandSize) {
                $brandSize->NombreMarca = $brandSize->brand->Nombre ?? '';
                $brandSize->DescripcionTamano = $brandSize->size->descripcion_completa ?? '';
                return $brandSize;
            });
    }

    public function getById(int $id): ?BrandSize
    {
        return $this->model
            ->with(['brand', 'size'])
            ->find($id);
    }

    public function create(array $data): BrandSize
    {
        return $this->model->create([
            'MarcaId' => $data['MarcaId'],
            'TamanoId' => $data['TamanoId'],
            'Estado' => $data['Estado'] ?? true
        ]);
    }

    public function update(int $id, array $data): bool
    {
        $brandSize = $this->model->find($id);

        if (!$brandSize) {
            return false;
        }

        return $brandSize->update([
            'Estado' => $data['Estado'] ?? $brandSize->Estado
        ]);
    }

    public function delete(int $id): bool
    {
        $brandSize = $this->model->find($id);

        if (!$brandSize) {
            return false;
        }

        return $brandSize->delete();
    }

    public function getByBrand(int $brandId): Collection
    {
        return $this->model
            ->with(['size:TamanoId,Descripcion,UnidadMedida,Valor'])
            ->byBrand($brandId)
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function getBySize(int $sizeId): Collection
    {
        return $this->model
            ->with(['brand:MarcaId,Nombre'])
            ->bySize($sizeId)
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function getActive(): Collection
    {
        return $this->model
            ->active()
            ->with(['brand:MarcaId,Nombre', 'size:TamanoId,Descripcion,UnidadMedida,Valor'])
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function toggleStatus(int $id): bool
    {
        $brandSize = $this->model->find($id);

        if (!$brandSize) {
            return false;
        }

        return $brandSize->Estado ? $brandSize->deactivate() : $brandSize->activate();
    }

    public function createAssociation(int $brandId, int $sizeId, bool $estado = true): BrandSize
    {
        return $this->model->firstOrCreate([
            'MarcaId' => $brandId,
            'TamanoId' => $sizeId,
        ], [
            'Estado' => $estado
        ]);
    }

    public function removeAssociation(int $brandId, int $sizeId): bool
    {
        $brandSize = $this->model
            ->byBrand($brandId)
            ->bySize($sizeId)
            ->first();

        if (!$brandSize) {
            return false;
        }

        return $brandSize->delete();
    }
}
