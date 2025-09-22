<?php

namespace App\Interfaces;

use App\Models\Role;
use Illuminate\Support\Collection;

interface RolesRepositoryInterface
{
    public function create(array $data): ?Role;
    public function update(int $id, array $data): bool;
    public function delete(int $id): bool;

    public function getById(int $id): ?Role;

    public function getAll(): Collection;

    public function getByName(string $name): ?Role;
}
