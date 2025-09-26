<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class EditUserRequest extends FormRequest
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
        $userId = $this->route('user') ?? $this->route('id'); // Ajusta según tu ruta

        return [
            'nombre_usuario' => [
                'required',
                'string',
                'max:50',
                Rule::unique('usuarios', 'nombre_usuario')->ignore($userId),
                'regex:/^[a-zA-Z0-9._-]+$/'
            ],
            'email' => [
                'required',
                'string',
                'email',
                'max:100',
                Rule::unique('usuarios', 'email')->ignore($userId)
            ],
            'correo' => [
                'nullable',
                'string',
                'email',
                'max:100',
                'different:email'
            ],
            'password' => [
                'nullable', 
                'string',
                'min:8',
                'confirmed',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).*$/'
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
                'regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/'
            ],
            'rol' => [
                'required',
                'integer',
                'exists:roles,RolId'
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
                'regex:/^[\d\s\-\+\(\)]+$/'
            ],
            'identificacion' => [
                'required',
                'string',
                'max:20',
                Rule::unique('usuarios', 'identificacion')->ignore($userId),
                'regex:/^[0-9]{10,13}$/'
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
        $data = [];

        if ($this->has('nombre_usuario')) {
            $data['nombre_usuario'] = strtolower(trim($this->nombre_usuario));
        }

        if ($this->has('email')) {
            $data['email'] = strtolower(trim($this->email));
        }

        if ($this->has('nombre_completo')) {
            $data['nombre_completo'] = ucwords(strtolower(trim($this->nombre_completo)));
        }

        if ($this->has('telefono')) {
            $data['telefono'] = preg_replace('/[^\d\+]/', '', $this->telefono);
        }

        if ($this->has('identificacion')) {
            $data['identificacion'] = preg_replace('/[^\d]/', '', $this->identificacion);
        }

        $this->merge($data);
    }

    /**
     * Configure the validator instance.
     */
    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {
            // Validaciones adicionales personalizadas
            if ($this->password && $this->password === $this->nombre_usuario) {
                $validator->errors()->add('password', 'La contraseña no puede ser igual al nombre de usuario.');
            }
        });
    }
}
