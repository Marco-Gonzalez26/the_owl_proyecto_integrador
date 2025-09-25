<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BrandRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $brandId = $this->route('brand') ? $this->route('brand')->MarcaId : null;

        return [
            'Nombre' => 'required|string|max:100|unique:marcas,Nombre,' . $brandId . ',MarcaId',
            'Estado' => 'required|boolean',
        ];
    }

    public function messages(): array
    {
        return [
            // Nombre
            'Nombre.required' => 'El nombre de la marca es obligatorio',
            'Nombre.string' => 'El nombre debe ser texto válido',
            'Nombre.max' => 'El nombre no puede exceder los 100 caracteres',
            'Nombre.unique' => 'Ya existe una marca con este nombre',

            // Estado
            'Estado.required' => 'Debe seleccionar un estado para la marca',
            'Estado.boolean' => 'El estado debe ser válido (activo/inactivo)',
        ];
    }

    public function attributes(): array
    {
        return [
            'Nombre' => 'nombre de la marca',
            'Estado' => 'estado de la marca',
        ];
    }

    protected function prepareForValidation(): void
    {
        // Convertir string a boolean si viene como string
        if ($this->has('Estado')) {
            $this->merge([
                'Estado' => filter_var($this->Estado, FILTER_VALIDATE_BOOLEAN),
            ]);
        }
    }
}
