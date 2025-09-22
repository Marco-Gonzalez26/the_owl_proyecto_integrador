<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $table = 'articulos_pedido';
    const CREATED_AT = 'CreatedAt';
    const UPDATED_AT = 'UpdatedAt';

    protected $fillable = [
        'PedidoId',
        'ProductoId',
        'NombreProducto',
        'PrecioUnitario',
        'Cantidad',
        'PrecioTotal',
        'ImagenProducto'
    ];

    protected $casts = [
        'PrecioUnitario' => 'decimal:2',
        'PrecioTotal' => 'decimal:2',
        'Cantidad' => 'integer',
    ];


    public function order()
    {
        return $this->belongsTo(Order::class, 'PedidoId', 'PedidoId');
    }


    public function product()
    {
        return $this->belongsTo(Product::class, 'ProductoId', 'ProductoId');
    }
}
