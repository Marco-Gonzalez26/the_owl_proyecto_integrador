<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MeassureUnit extends Model
{
    protected $table = 'unidad_medida';
    protected $primaryKey = 'UnidadId';
    public $timestamps = true;

    protected $fillable = [
        'Descripcion',
        'Abreviacion',
        'UnidadId',
    ];

    protected $casts = [
        'UnidadId' => 'integer',
    ];
}
