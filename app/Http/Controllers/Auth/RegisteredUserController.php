<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Interfaces\RolesRepositoryInterface;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Inertia\Inertia;
use Inertia\Response;

class RegisteredUserController extends Controller
{

    protected $roleRepository;

    public function __construct(RolesRepositoryInterface $roleRepository)
    {
        $this->roleRepository = $roleRepository;
    }
    /**
     * Show the registration page.
     */
    public function create(): Response
    {
        return Inertia::render('auth/register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'nombre_completo' => 'required|string|max:255',
            'nombre_usuario' => 'required|string|max:255|unique:' . User::class,
            'identificacion' => 'required|string|min:10|max:255|unique:' . User::class,
            'correo' => 'required|string|lowercase|email|max:255|unique:' . User::class,
            'direccion' => 'required|string|max:255',
            'telefono' => 'required|string|max:255',
            'contrasena' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'nombre_completo' => $request->nombre_completo,
            "telefono" => $request->telefono,
            'identificacion' => $request->identificacion,
            'nombre_usuario' => $request->nombre_usuario,
            'contrasena' => Hash::make($request->password),
            'direccion' => $request->direccion,
            'correo' => $request->correo,
            'rol' => $this->roleRepository->getByName('cliente')->RolId
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect()->intended(route('catalog.index', absolute: false));
    }
}
