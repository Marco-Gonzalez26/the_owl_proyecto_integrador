<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateOrderStatusRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Aquí puedes agregar lógica de autorización específica
        // Por ejemplo, verificar si el usuario tiene permisos para editar pedidos
        return true; // o auth()->user()->can('update', $this->route('order'))
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {

        return [
            'Estado' => [
                'required',
                'string',
                Rule::in([
                    'pendiente de entrega',
                    'confirmado',
                    'procesando',
                    'preparando',
                    'enviado',
                    'entregado',
                    'cancelado',
                    'en espera de retiro'
                ])
            ],
            'EstadoPago' => [
                'required',
                'string',
                Rule::in([
                    'pendiente',
                    'pagado',
                    'fallido',
                    'reembolsado'
                ])
            ]
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'Estado.required' => 'El estado del pedido es obligatorio.',
            'Estado.string' => 'El estado del pedido debe ser una cadena de texto.',
            'Estado.in' => 'El estado del pedido seleccionado no es válido. Debe ser uno de: pendiente, confirmado, procesando, enviado, entregado, cancelado.',

            'EstadoPago.required' => 'El estado del pago es obligatorio.',
            'EstadoPago.string' => 'El estado del pago debe ser una cadena de texto.',
            'EstadoPago.in' => 'El estado del pago seleccionado no es válido. Debe ser uno de: pendiente, pagado, fallido, reembolsado.',
        ];
    }
}
