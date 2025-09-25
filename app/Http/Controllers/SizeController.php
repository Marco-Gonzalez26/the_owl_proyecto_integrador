<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Interfaces\MeasureUnitRepositoryInterface;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\SizeRequest;
use Inertia\Inertia;
use App\Interfaces\SizeRepositoryInterface;

class SizeController extends Controller
{
    private $sizeRepository;
    private $measureUnitRepository;
    public function __construct(SizeRepositoryInterface $sizeRepository, MeasureUnitRepositoryInterface $measureUnitRepository)
    {
        $this->sizeRepository = $sizeRepository;
        $this->measureUnitRepository = $measureUnitRepository;
    }

    // Obtener tamaños
    public function index()
    {
        $sizes = $this->sizeRepository->getAll();

        return Inertia::render('sizes/index', [
            'sizes' => $sizes,
        ]);
    }

    // Mostrar creacion de tamaño
    public function showCreate()
    {
        $measureUnits = $this->measureUnitRepository->getAll();


        return Inertia::render('sizes/showCreate', [
            'measureUnits' => $measureUnits
        ]);
    }
    // Mostrar edicion de tamaño
    public function showEdit(int $id)
    {

        $sizeToEdit = $this->sizeRepository->getById($id);
        $measureUnits = $this->measureUnitRepository->getAll();
        return Inertia::render('sizes/showEdit', [
            'measureUnits' => $measureUnits,
            'sizeToEdit' => $sizeToEdit
        ]);
    }

    // Creacion de un nuevo tamaño
    public function store(SizeRequest $request): RedirectResponse
    {
        $validated = $request->validated();


        $size = $this->sizeRepository->create($validated);
        if (!$size) return redirect()->back()->with('error', "Error al crear tamaño")->withInput();

        return redirect()->back()->with('success', "El tamaño ha sido creado correctamente");
    }

    // Actualizar tamaño
    public function update(SizeRequest $request, int $id): RedirectResponse
    {
        $validated = $request->validated();

        $editedSize = $this->sizeRepository->update($id, $validated);
        if (!$editedSize) return redirect()->back()->withErrors("Error al actualizar tamaño");

        return redirect()->back()->with("success", "El tamaño ha sido actualizado correctamente");
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
