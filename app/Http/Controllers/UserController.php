<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\EditUserRequest;
use App\Http\Requests\StoreUserRequest;
use App\Interfaces\RolesRepositoryInterface;
use App\Interfaces\UserRepositoryInterface as InterfacesUserRepositoryInterface;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;
use App\Interfaces\UserRepositoryInterface;

class UserController extends Controller
{
    protected $roleRepository;
    protected $userRepository;
    public function __construct(RolesRepositoryInterface $roleRepository, UserRepositoryInterface $userRepository)
    {
        $this->roleRepository = $roleRepository;
        $this->userRepository = $userRepository;
    }

    public function index()
    {
        $users = $this->userRepository->getAll();
        return Inertia::render('user/index', [
            'users' => $users
        ]);
    }

    public function show(int $id)
    {
        $user = $this->userRepository->getById($id);
        return Inertia::render('user/show', [
            'user' => $user
        ]);
    }
    public function showCreate()
    {
        $roles = $this->roleRepository->getAll();

        return Inertia::render('user/showCreate', [
            'roles' => $roles
        ]);
    }
    public function showEdit(int $id)
    {
        $user = $this->userRepository->getById($id);
        $roles = $this->roleRepository->getAll();
        return Inertia::render('user/showEdit', [
            'user' => $user,
            'roles' => $roles
        ]);
    }

    public function store(StoreUserRequest $request)
    {
        $data = $request->validated();
        $user = $this->userRepository->create($data);
        if (!$user) {
            return redirect()->route('users.index')->with('error', 'Error al crear el usuario');
        }
        return redirect()->route('users.index')->with('success', 'Usuario creado correctamente');
    }
    public function update(EditUserRequest $request, int $id): bool
    {
        $data = $request->validated();
        
        return $this->userRepository->update($id, $data);
    }

    public function destroy($id)
    {
        try {
            $result = $this->userRepository->delete($id);

            if ($result) {
                return redirect()->route('users.index')->with('success', 'Usuario eliminado correctamente');
            }

            return redirect()->route('users.index')->with('error', 'No se pudo eliminar el usuario');
        } catch (\Exception $e) {
            return redirect()->route('users.index')->with('error', $e->getMessage());
        }
    }
}
