<?php

namespace App\Repositories;

use App\Interfaces\BrandSizeRepositoryInterface;
use App\Models\BrandSize;
use App\Models\Size;
use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;

class BrandSizeRepository implements BrandSizeRepositoryInterface
{
    protected $brandSizeModel;
    protected $sizeModel;
    protected $productModel;


    public function __construct(BrandSize $brandSizeModel, Size $sizeModel, Product $productModel)
    {
        $this->brandSizeModel = $brandSizeModel;
        $this->sizeModel = $sizeModel;
        $this->productModel = $productModel;
    }

    public function getAll(): Collection
    {
        return $this->brandSizeModel->get();
    }

    public function getById(int $id): ?BrandSize
    {
        return $this->brandSizeModel->find($id);
    }

    public function getProductCountForBrandSize(int $brandId, int $sizeId): int
    {
        return $this->productModel->where('TamanoId', $sizeId)->where('MarcaId', $brandId)->count();
    }

    public function getByBrand(int $brandId): Collection
    {
        return $this->brandSizeModel->where('MarcaId', $brandId)
            ->with(['size:TamanoId,Descripcion,UnidadMedida,Valor'])
            ->get();
    }

    public function getUnassignedByBrand(int $brandId): Collection
    {
        $assignedSizeIds = $this->brandSizeModel->where('MarcaId', $brandId)->pluck('TamanoId');
        return $this->sizeModel->whereNotIn('TamanoId', $assignedSizeIds)->get();
    }

    /**
     * Crea una nueva asociación entre una marca y un tamaño.
     */
    public function createAssociation(int $brandId, int $sizeId): BrandSize
    {
        return $this->brandSizeModel->create([
            'MarcaId' => $brandId,
            'TamanoId' => $sizeId,
            'Estado' => 1,
        ]);
    }

    /**
     * Elimina una asociación existente entre una marca y un tamaño.
     */
    public function deleteAssociation(int $brandId, int $sizeId): bool
    {
        return (bool) $this->brandSizeModel->where('MarcaId', $brandId)
            ->where('TamanoId', $sizeId)
            ->delete();
    }

    /**
     * Sincroniza las asociaciones de una marca con una lista de IDs de tamaños.
     */
    public function syncSizes(int $brandId, array $sizeIds): void
    {

        $currentSizeIds = $this->brandSizeModel->where('MarcaId', $brandId)->pluck('TamanoId')->toArray();

        $sizesToDelete = array_diff($currentSizeIds, $sizeIds);
        if (!empty($sizesToDelete)) {
            $this->brandSizeModel->where('MarcaId', $brandId)
                ->whereIn('TamanoId', $sizesToDelete)
                ->delete();
        }

        $sizesToCreate = array_diff($sizeIds, $currentSizeIds);
        foreach ($sizesToCreate as $sizeId) {
            $this->createAssociation($brandId, $sizeId);
        }
    }
}
