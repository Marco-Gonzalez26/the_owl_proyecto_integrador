<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    protected $table = 'categorias';
    protected $primaryKey = 'CategoriaId';
    protected $fillable = [
        'Nombre',
        'Estado'
    ];

    public function productos(): HasMany
    {
        return $this->hasMany(Product::class);
    }
}
