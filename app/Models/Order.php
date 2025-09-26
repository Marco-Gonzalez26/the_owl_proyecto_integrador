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
        'StripeSesionId',
        'UsuarioId',
        'CorreoCliente',
        'NombreCliente',
        'Monto',
        'Moneda',
        'Estado',
        'EstadoPago',
        'DireccionFacturacion',
        'DireccionEnvio',
        'Codigo'
    ];
    public $timestamps = true;

    public function items()
    {
        return $this->hasMany(OrderItem::class, 'PedidoId', 'PedidoId');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'UsuarioId', 'id');
    }

    protected static function booted()
    {
        static::creating(function ($order) {
            if (!$order->codigo) {
                $order->codigo = 'PED-' . strtoupper(bin2hex(random_bytes(6)));
            }
        });
    }
}
