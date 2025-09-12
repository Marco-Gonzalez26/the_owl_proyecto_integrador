<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Interfaces\SizeRepositoryInterface;

class SizeController extends Controller
{
    private $sizeRepository;
    public function __construct(SizeRepositoryInterface $sizeRepository)
    {
        $this->sizeRepository = $sizeRepository;
    }

    // Creacion de un nuevo tamaño
    public function create(Request $request): RedirectResponse
    {
        $request->validate([
            "descripcion" => "required|string|max:255",
            "unidad_medida" => "required|string|max:10",
            "valor" => "required|numeric|min:0",
            "estado" => "boolean",
        ]);

        try {
            $exists = $this->sizeRepository->checkIfSizeValueExists($request->all());

            if ($exists) {
                return redirect(route("sizes.index"))->with('error', "Este tamaño ya existe");
            }

            $this->sizeRepository->create($request->all());

            return redirect()->with('success', "El tamaño ha sido creado correctamente");
        } catch (\Exception $e) {
            return redirect()->with('error', $e->getMessage());
        }
    }

    // Actualizar tamaño
    public function update(Request $request, int $id): RedirectResponse
    {
        $request->validate([
            "descripcion" => "required|string|max:255",
            "unidad_medida" => "required|string|max:10",
            "valor" => "required|numeric|min:0",
            "estado" => "boolean",
        ]);

        try {
            $exists = $this->sizeRepository->checkIfSizeValueExists($request->all());

            if ($exists) {
                return redirect()->with('error', "Este tamaño al que intenta actualizar ya existe");
            }

            $this->sizeRepository->update($id, $request->all());

            return redirect(route("sizes.index"))->with('success', "El tamaño ha sido actualizado correctamente");
        } catch (\Exception $e) {
            return redirect(route('sizes.index'))->with('error', $e->getMessage());
        }
    }

    // Eliminar tamaño
    public function destroy(int $id): RedirectResponse
    {
        try {
            $this->sizeRepository->delete($id);

            return redirect(route("sizes.index"))->with('success', "El tamaño ha sido desactivado correctamente");
        } catch (\Exception $e) {
            return redirect(route('sizes.index'))->with('error', $e->getMessage());
        }
    }
}
