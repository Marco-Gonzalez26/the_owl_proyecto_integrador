<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SizeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'Descripcion' => 'required|string|max:100,Descripcion',
            'UnidadMedida' => 'required|integer|exists:unidad_medida,UnidadId',
            'Valor' => 'required|numeric|min:0|max:999999.99',
        ];
    }

    public function messages(): array
    {
        return [

            'Descripcion.required' => 'La descripción del tamaño es obligatoria',
            'Descripcion.string' => 'La descripción debe ser texto válido',
            'Descripcion.max' => 'La descripción no puede exceder los 100 caracteres',
            'Descripcion.unique' => 'Ya existe un tamaño con esta descripción',


            'UnidadMedida.required' => 'Debe seleccionar una unidad de medida',
            'UnidadMedida.integer' => 'La unidad de medida debe ser un valor válido',
            'UnidadMedida.exists' => 'La unidad de medida seleccionada no existe',


            'Valor.required' => 'El valor numérico es obligatorio',
            'Valor.numeric' => 'El valor debe ser un número válido',
            'Valor.min' => 'El valor no puede ser negativo',
            'Valor.max' => 'El valor no puede exceder 999999.99',
        ];
    }

    public function attributes(): array
    {
        return [
            'Descripcion' => 'descripción del tamaño',
            'UnidadMedida' => 'unidad de medida',
            'Valor' => 'valor numérico',
        ];
    }
}
