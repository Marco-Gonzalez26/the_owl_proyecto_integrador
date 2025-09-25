<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;


class Brand extends Model
{


    protected $table = 'marcas';
    protected $primaryKey = 'MarcaId';

    protected $fillable = [
        'Nombre',
        'Estado',
    ];



    // Relacion muchos a muchos de los tamaños y marcas
    public function sizes()
    {
        return $this->belongsToMany(
            Size::class,
            'marca_tamanos',
            'marca_id',
            'tamano_id'
        )->withPivot('estado')
            ->withTimestamps();
    }

    // Retornar tamaños activos de la marca
    public function activeSizes()
    {
        return $this->sizes()
            ->wherePivot('estado', true)
            ->where('sizes.Estado', true);
    }


    public function availableSizes()
    {
        return Size::active()
            ->whereNotIn('TamanoId', $this->sizes->pluck('TamanoId'))
            ->ordered();
    }

    public function products()
    {
        return $this->hasMany(Product::class, 'MarcaId', 'MarcaId');
    }


    public function scopeActive($query)
    {
        return $query->where('Estado', true);
    }


    public function assignSize($tamanoId, $estado = true, $precioSugerido = null)
    {
        if (!$this->sizes()->where('tamano_id', $tamanoId)->exists()) {
            return $this->sizes()->attach($tamanoId, [
                'estado' => $estado

            ]);
        }
        return false;
  }

    // Quitar tamaño a marca
    public function unassignSize($tamanoId)
    {
        return $this->sizes()->detach($tamanoId);
    }

    // Eliminacion logica de un tamaño
    public function updateSizeStatus($tamanoId, $estado, $precioSugerido = null)
    {
        return $this->sizes()->updateExistingPivot($tamanoId, [
            'Estado' => $estado
        ]);
    }
}
