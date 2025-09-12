<?php

namespace App\Http\Controllers;

use App\Interfaces\BrandRepositoryInterface;
use App\Interfaces\BrandSizeRepositoryInterface;
use App\Models\Brand;
use App\Models\Size;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class BrandSizeController extends Controller
{
    private $brandSizeRepository;
    private $brandRepository;
    public function __construct(BrandSizeRepositoryInterface $brandSizeRepository, BrandRepositoryInterface $brandRepository)
    {
        $this->brandSizeRepository = $brandSizeRepository;
        $this->brandRepository = $brandRepository;
    }
    /**
     * Gestión de tamaños para una marca específica
     */
    public function index(Brand $brand)
    {
        $availableSizes = $this->brandSizeRepository->getByBrand($brand->id);

        return Inertia::render('brands/sizes/index', [
            'brand' => $brand,
            'assignedSizes' => $brand->sizes,
            'availableSizes' => $availableSizes,
        ]);
    }

    /**
     * Asignar tamaños a una marca
     */
    public function assignSizes(Request $request, Brand $brand)
    {
        $request->validate([
            'tamano_ids' => 'required|array',
            'tamano_ids.*' => 'exists:sizes,TamanoId'
        ]);

        try {
            DB::beginTransaction();

            $assigned = 0;
            $skipped = 0;

            foreach ($request->tamano_ids as $index => $tamanoId) {


                if ($this->brandRepository->assignSize($tamanoId, true)) {
                    $assigned++;
                } else {
                    $skipped++;
                }
            }

            DB::commit();

            $message = "Se asignaron {$assigned} tamaños";
            if ($skipped > 0) {
                $message .= " (se omitieron {$skipped} ya existentes)";
            }

            return redirect()->back()->with('success', $message);
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Error al asignar tamaños: ' . $e->getMessage());
        }
    }

    /**
     * Actualizar asignación específica
     */
    public function updateAssignment(Request $request, Brand $brand, Size $size)
    {
        $request->validate([
            'estado' => 'required|boolean',
            'precio_sugerido' => 'nullable|numeric|min:0',
        ]);

        try {
            $this->brandRepository->updateSizeStatus(
                $size->TamanoId,
                $request->estado
            );

            $status = $request->estado ? 'activado' : 'desactivado';
            return redirect()->back()->with('success', "Tamaño {$status} para esta marca");
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error al actualizar: ' . $e->getMessage());
        }
    }

    /**
     * Desasignar tamaño de una marca
     */
    public function unassignSize(Brand $brand, Size $size)
    {
        try {
            // Verificar si hay productos de esta marca con este tamaño
            $productCount = $brand->products()
                ->where('TamanoId', $size->TamanoId)
                ->count();

            if ($productCount > 0) {
                return redirect()->back()->with(
                    'error',
                    "No se puede desasignar. Hay {$productCount} producto(s) de esta marca usando este tamaño."
                );
            }

            $brand->unassignSize($size->TamanoId);

            return redirect()->back()->with('success', 'Tamaño desasignado correctamente');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error al desasignar: ' . $e->getMessage());
        }
    }

    /**
     * API: Obtener tamaños activos de una marca
     */
    public function getSizesByBrand(Brand $brand)
    {
        $sizes = $brand->activeSizes()
            ->select('sizes.TamanoId', 'sizes.Descripcion', 'sizes.UnidadMedida', 'sizes.Valor')
            ->addSelect('brand_sizes.precio_sugerido')
            ->get()
            ->map(function ($size) {
                return [
                    'id' => $size->TamanoId,
                    'label' => $size->descripcion_detallada,
                    'valor' => $size->Valor,
                    'unidad' => $size->UnidadMedida
                ];
            });

        return response()->json($sizes);
    }

    /**
     * Vista general de asignaciones
     */
    public function overview()
    {
        $brands = Brand::active()
            ->with(['sizes' => function ($query) {
                $query->withPivot('estado', 'precio_sugerido')
                    ->orderBy('Valor');
            }])
            ->get();

        return Inertia::render('BrandSizes/Overview', [
            'brands' => $brands,
        ]);
    }
}
