<?php

namespace App\Http\Controllers;

use App\Interfaces\BrandRepositoryInterface;
use App\Models\Brand;
use Inertia\Inertia;
use Inertia\Response;

class BrandController extends Controller
{
    private $brandRepository;
    public function __construct(BrandRepositoryInterface $brandRepository)
    {
        $this->brandRepository = $brandRepository;
    }

    public function index(): Response
    {

        $brands = $this->brandRepository->getAll();
        
        return Inertia::render('brands/index', [
            'brands' => $brands
        ]);
    }

    public function showCreate(int $id): Response
    {
        return Inertia::render('brands/create');
    }
    public function showEdit(int $id): Response
    {
        $brandToEdit = $this->brandRepository->getById($id);
        return Inertia::render('brands/edit', ["brandToEdit" => $brandToEdit]);
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
    public function create(array $data): Brand
    {
        return $this->brandRepository->create($data);
    }

    public function update(int $id, array $data): bool
    {
        return $this->brandRepository->update($id, $data);
    }
    public function delete(int $id): bool
    {
        return $this->brandRepository->delete($id);
    }
}
