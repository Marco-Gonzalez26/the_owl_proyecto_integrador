<?php
namespace App\Interfaces;

use App\Models\BrandSize;
use Illuminate\Database\Eloquent\Collection;

interface BrandSizeRepositoryInterface
{
public function getAll(): Collection;
public function getById(int $id): ?BrandSize;
public function create(array $data): BrandSize;
public function update(int $id, array $data): bool;
public function delete(int $id): bool;
public function getByBrand(int $brandId): Collection;
public function getBySize(int $sizeId): Collection;
public function getActive(): Collection;
public function toggleStatus(int $id): bool;
public function createAssociation(int $brandId, int $sizeId, bool $estado = true): BrandSize;
public function removeAssociation(int $brandId, int $sizeId): bool;
}
