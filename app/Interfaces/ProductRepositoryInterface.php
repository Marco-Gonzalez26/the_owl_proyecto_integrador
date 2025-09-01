<?php

namespace App\Interfaces;

use Illuminate\Database\Eloquent\Collection;
use App\Models\Product;

interface ProductRepositoryInterface
{
    public function getAll(): Collection;
    public function getById(int $id): ?Product;
    public function create(array $data): Product;
    public function update(int $id, array $data): bool;

    public function delete(int $id): bool;
}
