<?php

namespace App\Interfaces;

use App\Models\Brand;
use Illuminate\Database\Eloquent\Collection;

interface BrandRepositoryInterface
{
    public function getAll(): Collection;
    public function getById(int $id): ?Brand;
    public function create(array $data): Brand;
    public function update(int $id, array $data): bool;
    public function delete(int $id): bool;
    public function assignSize($sizeId, $state = true): bool;

    public function updateSizeStatus($sizeId, $state): bool;
}
