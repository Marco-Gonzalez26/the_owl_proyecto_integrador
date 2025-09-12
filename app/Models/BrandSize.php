<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BrandSize extends Model
{
    use HasFactory;

    protected $table = 'marca_tamanos';
    protected $primaryKey = 'Id';
    public $timestamps = true;

    protected $fillable = [
        'MarcaId',
        'TamanoId',
        'Estado',
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

    /**
     * Scope para asociaciones activas
     */
    public function scopeActive($query)
    {
        return $query->where('Estado', true);
    }

    /**
     * Scope para asociaciones inactivas
     */
    public function scopeInactive($query)
    {
        return $query->where('Estado', false);
    }

    /**
     * Scope para filtrar por marca
     */
    public function scopeByBrand($query, $brandId)
    {
        return $query->where('MarcaId', $brandId);
    }

    /**
     * Scope para filtrar por tamaño
     */
    public function scopeBySize($query, $sizeId)
    {
        return $query->where('TamanoId', $sizeId);
    }

    /**
     * Scope para obtener con relaciones
     */
    public function scopeWithRelations($query)
    {
        return $query->with(['brand', 'size']);
    }

    /**
     * Verificar si la asociación existe
     */
    public static function exists($brandId, $sizeId): bool
    {
        return self::where('MarcaId', $brandId)
            ->where('TamanoId', $sizeId)
            ->exists($brandId, $sizeId);
    }

    /**
     * Crear o actualizar asociación
     */
    public static function createOrUpdate($brandId, $sizeId, $estado = true): self
    {
        return self::updateOrCreate(
            [
                'MarcaId' => $brandId,
                'TamanoId' => $sizeId,
            ],
            [
                'Estado' => $estado,
            ]
        );
    }

    /**
     * Activar asociación
     */
    public function activate(): bool
    {
        return $this->update(['Estado' => true]);
    }

    /**
     * Desactivar asociación
     */
    public function deactivate(): bool
    {
        return $this->update(['Estado' => false]);
    }

    /**
     * Alternar estado
     */
    public function toggle(): bool
    {
        return $this->update(['Estado' => !$this->Estado]);
    }

    /**
     * Obtener descripción completa de la asociación
     */
    public function getDescripcionCompletaAttribute(): string
    {
        $brand = $this->brand;
        $size = $this->size;

        return "{$brand->Nombre} - {$size->descripcion_completa}";
    }

    /**
     * Verificar si hay productos usando esta asociación
     */
    public function hasProducts(): bool
    {
        return Product::where('MarcaId', $this->MarcaId)
            ->where('TamanoId', $this->TamanoId)
            ->exists();
    }

    /**
     * Contar productos que usan esta asociación
     */
    public function getProductsCountAttribute(): int
    {
        return Product::where('MarcaId', $this->MarcaId)
            ->where('TamanoId', $this->TamanoId)
            ->count();
    }

    /**
     * Boot method para eventos del modelo
     */
    protected static function boot()
    {
        parent::boot();

        // Evento antes de eliminar
        static::deleting(function ($brandSize) {
            // Verificar si hay productos usando esta asociación
            if ($brandSize->hasProducts()) {
                throw new \Exception(
                    "No se puede eliminar la asociación. Hay {$brandSize->products_count} producto(s) usando esta combinación."
                );
            }
        });
    }

    /**
     * Métodos estáticos de utilidad
     */

    /**
     * Obtener todas las asociaciones activas
     */
    public static function getActive()
    {
        return self::active()->withRelations()->get();
    }

    /**
     * Obtener asociaciones por marca
     */
    public static function getByBrand($brandId)
    {
        return self::byBrand($brandId)->withRelations()->get();
    }

    /**
     * Obtener asociaciones por tamaño
     */
    public static function getBySize($sizeId)
    {
        return self::bySize($sizeId)->withRelations()->get();
    }

    /**
     * Activar múltiples asociaciones
     */
    public static function activateMultiple(array $ids): int
    {
        return self::whereIn('id', $ids)->update([
            'Estado' => true,
            'updated_at' => now(),
        ]);
    }

    /**
     * Desactivar múltiples asociaciones
     */
    public static function deactivateMultiple(array $ids): int
    {
        return self::whereIn('id', $ids)->update([
            'Estado' => false,
            'updated_at' => now(),
        ]);
    }

    /**
     * Eliminar múltiples asociaciones (solo si no tienen productos)
     */
    public static function deleteMultiple(array $ids): array
    {
        $results = ['deleted' => 0, 'errors' => []];

        $brandSizes = self::whereIn('id', $ids)->get();

        foreach ($brandSizes as $brandSize) {
            try {
                if ($brandSize->hasProducts()) {
                    $results['errors'][] = "ID {$brandSize->id}: Tiene {$brandSize->products_count} producto(s)";
                } else {
                    $brandSize->delete();
                    $results['deleted']++;
                }
            } catch (\Exception $e) {
                $results['errors'][] = "ID {$brandSize->id}: {$e->getMessage()}";
            }
        }

        return $results;
    }
}
