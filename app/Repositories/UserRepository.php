<?php

namespace App\Repositories;

use App\Interfaces\UserRepositoryInterface;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Hash;


class UserRepository implements UserRepositoryInterface
{
    protected $model;

    public function __construct(User $model)
    {
        $this->model = $model;
    }

    public function getAll(): Collection
    {
        return $this->model
            ->with('role')
            ->get();
    }

    public function getById(int $id): ?User
    {
        $user = $this->model->with('role')->find($id);
        if (!$user) {
            return null;
        }
        return $user;
    }
    public function create(array $data): ?User
    {
        $user = $this->model->create([
            'nombre_usuario' => $data['nombre_usuario'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            "contrasena" => Hash::make($data['password']),
            'nombre_completo' => $data['nombre_completo'],
            'correo' => $data['email'],
            'rol' => $data['rol'],
            'direccion' => $data['direccion'],
            'telefono' => $data['telefono'],
            'identificacion' => $data['identificacion'],
        ]);
        if (!$user) {
            return null;
        }
        return $user;
    }

    public function update(int $id, array $data): bool
    {
        $user = $this->model->find($id);

        if (!$user) {
            return false;
        }

        return $user->update([
            'nombre_usuario' => $data['nombre_usuario'],

            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            "contrasena" => Hash::make($data['password']),
            'nombre_completo' => $data['nombre_completo'],
            'correo' => $data['email'],
            'rol' => $data['rol'],
            'direccion' => $data['direccion'],
            'telefono' => $data['telefono'],
            'identificacion' => $data['identificacion'],
        ]);
    }

    public function delete(int $id): bool
    {
        $user = $this->getById($id);

        if (!$user) {
            return false;
        }

        if ($user->rol == 1) { // ID del rol administrador
            $adminCount = $this->model->where('RolId', 1)->count();

            if ($adminCount <= 1) {
                throw new \Exception('No se puede eliminar el último administrador del sistema.');
            }
        }

        return $user->delete();
    }
}
