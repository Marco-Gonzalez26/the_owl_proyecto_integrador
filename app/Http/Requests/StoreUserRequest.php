<?php

// StoreUserRequest.php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Ajusta según tu lógica de autorización
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nombre_usuario' => [
                'required',
                'string',
                'max:50',
                'unique:usuarios,nombre_usuario',
                'regex:/^[a-zA-Z0-9._-]+$/' // Solo permite letras, números, puntos, guiones y guiones bajos
            ],
            'email' => [
                'required',
                'string',
                'email',
                'max:100',
                'unique:usuarios,email'
            ],
            'correo' => [
                'nullable',
                'string',
                'email',
                'max:100',
                'different:email' // Si decides usar ambos campos
            ],
            'password' => [
                'required',
                'string',
                'min:8',
                'confirmed', // Requiere password_confirmation
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).*$/' // Al menos una minúscula, una mayúscula y un número
            ],
            'contrasena' => [
                'nullable',
                'string',
                'min:8'
            ],
            'nombre_completo' => [
                'required',
                'string',
                'max:100',
                'regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/' // Solo letras y espacios (incluyendo acentos)
            ],
            'rol' => [
                'required',
                'integer',
                'exists:roles,RolId' // Asume que tienes una tabla roles con campo RolId
            ],
            'direccion' => [
                'nullable',
                'string',
                'max:255'
            ],
            'telefono' => [
                'nullable',
                'string',
                'max:20',
                'regex:/^[\d\s\-\+\(\)]+$/' // Solo números, espacios, guiones, + y paréntesis
            ],
            'identificacion' => [
                'required',
                'string',
                'max:20',
                'unique:usuarios,identificacion',
                'regex:/^[0-9]{10,13}$/' // Para cédulas ecuatorianas (10 dígitos) o pasaportes
            ]
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'nombre_usuario.required' => 'El nombre de usuario es obligatorio.',
            'nombre_usuario.unique' => 'Este nombre de usuario ya está en uso.',
            'nombre_usuario.regex' => 'El nombre de usuario solo puede contener letras, números, puntos, guiones y guiones bajos.',
            'email.required' => 'El email es obligatorio.',
            'email.email' => 'Ingresa un email válido.',
            'email.unique' => 'Este email ya está registrado.',
            'password.required' => 'La contraseña es obligatoria.',
            'password.min' => 'La contraseña debe tener al menos 8 caracteres.',
            'password.confirmed' => 'Las contraseñas no coinciden.',
            'password.regex' => 'La contraseña debe contener al menos una mayúscula, una minúscula y un número.',
            'nombre_completo.required' => 'El nombre completo es obligatorio.',
            'nombre_completo.regex' => 'El nombre completo solo puede contener letras y espacios.',
            'rol.required' => 'El rol es obligatorio.',
            'rol.exists' => 'El rol seleccionado no existe.',
            'telefono.regex' => 'Ingresa un número de teléfono válido.',
            'identificacion.required' => 'La identificación es obligatoria.',
            'identificacion.unique' => 'Esta identificación ya está registrada.',
            'identificacion.regex' => 'Ingresa un número de identificación válido (10-13 dígitos).',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes(): array
    {
        return [
            'nombre_usuario' => 'nombre de usuario',
            'email' => 'correo electrónico',
            'password' => 'contraseña',
            'nombre_completo' => 'nombre completo',
            'rol' => 'rol',
            'direccion' => 'dirección',
            'telefono' => 'teléfono',
            'identificacion' => 'identificación'
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        // Limpia y formatea los datos antes de la validación
        $this->merge([
            'nombre_usuario' => strtolower(trim($this->nombre_usuario)),
            'email' => strtolower(trim($this->email)),
            'nombre_completo' => ucwords(strtolower(trim($this->nombre_completo))),
            'telefono' => preg_replace('/[^\d\+]/', '', $this->telefono), // Remueve todo excepto números y +
            'identificacion' => preg_replace('/[^\d]/', '', $this->identificacion) // Solo números
        ]);
    }
}
