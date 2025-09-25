<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'Nombre' => 'required|string|max:50|unique:categorias',
            'Estado' => 'required|int'
        ];
    }

    public function messages()
    {
        return [
            'Nombre.required' => 'El nombre de la categoría es obligatorio',
            'Nombre.unique' => 'Ya existe una categoría con este nombre',
            'Nombre.max' => 'El nombre no puede exceder los 255 caracteres',
            'Descripcion.max' => 'La descripción no puede exceder los 255 caracteres',
            'Descripcion.required' => 'La descripción es obligatoria',
            'Estado.required' => 'Debe seleccionar un estado',
        ];
    }

    public function attributes()
    {
        return [
            'Nombre' => 'nombre de la categoría',
            'Descripcion' => 'descripción',
            'Estado' => 'estado',
        ];
    }
}
