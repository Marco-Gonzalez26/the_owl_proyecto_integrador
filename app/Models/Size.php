<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Size extends Model
{

    protected $table = 'tamanos';
    protected $primaryKey = 'TamanoId';
    public $timestamps = true;

    protected $fillable = [
        'Descripcion',
        'UnidadMedida',
        'Valor',
    ];

    protected $casts = [
        'Valor' => 'decimal:2',

    ];


    public function brands()
    {
        return $this->belongsToMany(
            Brand::class,
            'marca_tamanos',
            'TamanoId',
            'MarcaId'
        )->withPivot('Estado')
            ->withTimestamps();
    }

    public function isUsedByBrands()
    {
        return $this->brands()->exists();
    }

    public function products()
    {
        return $this->hasMany(Product::class, 'TamanoId', 'TamanoId');
    }
    
    public function canBeDeleted()
    {
        return !$this->isUsedByBrands() && $this->products_count === 0;
    }

    public function getDescripcionCompletaAttribute()
    {
        return $this->Valor . $this->UnidadMedida;
    }
}
