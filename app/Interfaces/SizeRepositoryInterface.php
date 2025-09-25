<?php

namespace App\Interfaces;

use App\Models\Size;
use Illuminate\Database\Eloquent\Collection;

interface SizeRepositoryInterface
{
    public function getAll(): Collection;
    public function getById(int $id): Size;
    public function create(array $data): Size;
    public function update(int $id, array $data): bool;
    public function delete(int $id): bool;


    public function checkIfSizeValueExists(array $data): bool;
}
