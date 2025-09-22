<?php

namespace App\Repositories;

use App\Interfaces\RolesRepositoryInterface;
use App\Models\Role;

class RolesRepository implements RolesRepositoryInterface
{
    public function create(array $data): ?Role
    {
        return Role::create($data);
    }

    public function update(int $id, array $data): bool
    {

        try {
            $role = Role::findOrFail($id);
            $role->update($data);
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function delete(int $id): bool
    {

        try {
            $role = Role::findOrFail($id);
            $role->delete();
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function getById(int $id): ?Role
    {
        return Role::find($id);
    }

    public function getAll(): \Illuminate\Support\Collection
    {
        return Role::all();
    }

    public function getByName(string $name): ?Role
    {
        return Role::where('Nombre', $name)->first();
    }
}
