<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Interfaces\CategoryRepositoryInterface;

use App\Http\Requests\CategoryRequest;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response as InertiaResponse;

class CategoriesController extends Controller
{
    protected $categoryRepository;

    public function __construct(CategoryRepositoryInterface $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function index(): InertiaResponse
    {
        $categories = $this->categoryRepository->getAll();
        return Inertia::render('categories/index', [
            'categories' => $categories
        ]);
    }
    public function show(int $id): InertiaResponse
    {
        $category = $this->categoryRepository->getById($id);
        return Inertia::render('categories/show', [
            'category' => $category
        ]);
    }
    public function store(CategoryRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        $category = $this->categoryRepository->create($validated);
        if (!$category) {
            return redirect()->route('categories.index')->with('message', 'Categoría no creada');
        }
        return redirect()->route('categories.index')->with('message', 'Categoría creada correctamente');
    }

    public function showCreate(): InertiaResponse
    {
        return Inertia::render('categories/showCreate');
    }
    public function showEdit(int $id): InertiaResponse
    {
        $category = $this->categoryRepository->getById($id);
        return Inertia::render('categories/showEdit', [
            'category' => $category
        ]);
    }

    public function update(CategoryRequest $request, int $id): RedirectResponse
    {
        $validated = $request->validated();
        $updated = $this->categoryRepository->update($id, $validated);
        if (!$updated) {
            return redirect()->route('categories.index')->with('message', 'Categoría no actualizada');
        }
        return redirect()->route('categories.index')->with('message', 'Categoría actualizada correctamente');
    }
    public function destroy(int $id): RedirectResponse
    {
        $deleted = $this->categoryRepository->delete($id);
        if (!$deleted) {
            return redirect()->route('categories.index')->with('message', 'Categoría no eliminada');
        }
        return redirect()->route('categories.index')->with('message', 'Categoría eliminada correctamente');
    }
}
