<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {

        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules()
    {
        return [
            'Nombre' => 'required|string|max:255',
            'Descripcion' => 'nullable|string',
            'Precio' => 'required|numeric|min:0',
            'Stock' => 'required|integer|min:0',
            'Imagen' => 'required|image|max:2048',
            'CategoriaId' => 'required|integer|exists:categorias,CategoriaId',
            'MarcaId' => 'required|integer|exists:marcas,MarcaId',
            'TamanoId' => 'required|integer|exists:tamanos,TamanoId',
            'PrecioMayorista' => 'required|numeric|min:0.01',
            'MinimoMayorista' => 'required|numeric|min:1',
        ];
    }

    public function messages()
    {
        return [
            'Nombre.required' => 'El nombre del producto es obligatorio.',
            'Nombre.string' => 'El nombre debe ser una cadena de texto.',
            'Precio.required' => 'El precio es obligatorio.',
            'Precio.numeric' => 'El precio debe ser un número.',
            'Precio.min' => 'El precio no puede ser negativo.',
            'Stock.required' => 'El stock es obligatorio.',
            'Stock.integer' => 'El stock debe ser un número entero.',
            'Stock.min' => 'El stock no puede ser negativo.',
            'Imagen.image' => 'El archivo debe ser una imagen.',
            'Imagen.max' => 'La imagen no puede pesar más de 2MB.',
            'CategoriaId.required' => 'Debes seleccionar una categoría.',
            'CategoriaId.exists' => 'La categoría seleccionada no es válida.',
            'MarcaId.required' => 'Debes seleccionar una marca.',
            'MarcaId.exists' => 'La marca seleccionada no es válida.',
            'TamanoId.required' => 'Debes seleccionar un tamaño.',
            'TamanoId.exists' => 'El tamaño seleccionado no es válido.',
            'PrecioMayorista.required' => 'Debes ingresar un precio mayorista.',
            "PrecioMayorista.numeric" => "El precio mayorista debe ser un número.",
            "PrecioMayorista.min" => "El precio mayorista no puede ser negativo.",
            "MinimoMayorista.required" => "Debe ingresar una cantidad minima mayorista.",
            "MinimoMayorista.numeric" => "La cantidad minima mayorista debe ser un número.",
            "MinimoMayorista.min" => "La cantidad minima mayorista no puede ser negativo.",
        ];
    }
}
