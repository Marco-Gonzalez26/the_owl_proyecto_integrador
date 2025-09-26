<?php

namespace App\Http\Controllers;

use App\Http\Requests\BrandRequest;
use App\Http\Requests\EditBrandRequest;
use App\Interfaces\BrandRepositoryInterface;
use App\Interfaces\BrandSizeRepositoryInterface;
use App\Interfaces\SizeRepositoryInterface;
use App\Models\Brand;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class BrandController extends Controller
{
    private $brandRepository;
    private $brandSizeRepository;
    private $sizeRepository;
    public function __construct(BrandRepositoryInterface $brandRepository, BrandSizeRepositoryInterface $brandSizeRepository, SizeRepositoryInterface $sizeRepository)
    {
        $this->brandRepository = $brandRepository;
        $this->brandSizeRepository = $brandSizeRepository;
        $this->sizeRepository = $sizeRepository;
    }

    public function index(): Response
    {

        $brands = $this->brandRepository->getAll();

        return Inertia::render('brands/index', [
            'brands' => $brands
        ]);
    }

    public function showCreate(): Response
    {
        return Inertia::render('brands/showCreate');
    }
    public function showEdit(int $id): Response
    {
        $associatedSizes = $this->brandSizeRepository->getByBrand($id);
        $allSizes = $this->sizeRepository->getAll();
        $brandToEdit = $this->brandRepository->getById($id);
        return Inertia::render('brands/showEdit', ["brandToEdit" => $brandToEdit, "associatedSizes" => $associatedSizes, "allSizes" => $allSizes]);
    }
    public function showById(int $id): Response
    {
        $brand = $this->brandRepository->getById($id);
        return Inertia::render('brands/show', [
            'brand' => $brand
        ]);
    }

    public function getById(int $id): ?Brand
    {
        return $this->brandRepository->getById($id);
    }
    public function store(BrandRequest $request): RedirectResponse
    {

        $validated = $request->validated();
        $brand = $this->brandRepository->create($validated);
        if (!$brand) return redirect()->back()->with('message', 'Marca no creada');

        return redirect()->back()->with('message', 'Marca creada correctamente');
    }

    public function update(int $id, EditBrandRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        $brand = $this->brandRepository->update($id, $validated);
        if (!$brand) return redirect()->route('brands.index')->with('message', 'Marca no actualizada');

        return redirect()->back()->with('message', 'Marca creada correctamente');
    }
    public function delete(int $id): bool
    {
        return $this->brandRepository->delete($id);
    }
}
