<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BrandSize extends Model
{


    protected $table = 'marca_tamano';
    protected $primaryKey = 'Id';
    public $timestamps = true;

    protected $fillable = [
        'MarcaId',
        'TamanoId',
        "Estado"
    ];

    protected function casts(): array
    {
        return [
            'Estado' => 'boolean',
            'MarcaId' => 'integer',
            'TamanoId' => 'integer',
        ];
    }

    /**
     * Relación con Brand
     */
    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class, 'MarcaId', 'MarcaId');
    }

    /**
     * Relación con Size
     */
    public function size(): BelongsTo
    {
        return $this->belongsTo(Size::class, 'TamanoId', 'TamanoId');
    }
}
