<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    protected $table = 'productos';


    protected $primaryKey = 'ProductoId';
    protected $fillable = [
        'Nombre',
        'Descripcion',
        'Precio',
        'Stock',
        'Imagen',
        "CategoriaId",
        "MinimoMayorista"
    ];
    protected $casts = [
        'Precio' => 'decimal:2',
        'Stock' => 'integer',
        "CategoriaId" => "integer",
        "ProveedorId" => "integer",
        "MarcaId" => "integer",
        "PrecioMayorista" => "decimal:2",
        "MinimoMayorista" => "integer",
    ];



    public function categoria(): BelongsTo
    {
        return $this->belongsTo(Category::class, "CategoriaId", "CategoriaId");
    }
}
