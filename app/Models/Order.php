<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'pedidos';
    protected $primaryKey = 'PedidoId';

    const CREATED_AT = 'CreatedAt'; 
    const UPDATED_AT = 'UpdatedAt';

    protected $fillable = [
        'StripeSesionId', 'UsuarioId', 'CorreoCliente', 'NombreCliente',
        'Monto', 'Moneda', 'Estado', 'EstadoPago',
        'DireccionFacturacion', 'DireccionEnvio'
    ];
    public $timestamps = true;

    public function items() {
        return $this->hasMany(OrderItem::class, 'PedidoId', 'PedidoId');
    }
}
