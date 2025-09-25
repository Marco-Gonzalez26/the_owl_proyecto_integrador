<?php

namespace App\Interfaces;

use App\Models\BrandSize;
use Illuminate\Database\Eloquent\Collection;

interface BrandSizeRepositoryInterface
{
    public function getAll(): Collection;
    public function getById(int $id): ?BrandSize;



    public function getByBrand(int $brandId): Collection;


    public function getProductCountForBrandSize(int $brandId, int $sizeId): int;
    public function createAssociation(int $brandId, int $sizeId): BrandSize;
    public function deleteAssociation(int $brandId, int $sizeId): bool;
}
