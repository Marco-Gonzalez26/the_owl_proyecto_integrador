<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Interfaces\CategoryRepositoryInterface;
use App\Interfaces\ProductRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response as InertiaResponse;

class ProductController extends Controller
{
    protected $productRepository;
    protected $categoryRepository;

    public function __construct(ProductRepositoryInterface $productRepository, CategoryRepositoryInterface $categoryRepository)
    {
        $this->productRepository = $productRepository;
        $this->categoryRepository = $categoryRepository;
    }

    public function index(): InertiaResponse
    {
        $products = $this->productRepository->getAll();

        return Inertia::render('products/index', [
            'products' => $products
        ]);
    }

    public function show(int $id): InertiaResponse
    {
        $product = $this->productRepository->getById($id);



        return Inertia::render('products/showById', [
            'product' => $product
        ]);
    }

    public function showCreate(): InertiaResponse
    {
        $categories = $this->categoryRepository->getAll();
        return Inertia::render('products/showCreate', ["categories" => $categories]);
    }
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0.01',
            'stock' => 'required|integer|min:0',
            'imageUrl' => 'required|string',
            'categoryId' => 'required|integer|exists:categorias,CategoriaId'
        ]);

        $product = $this->productRepository->create($validated);
        if (!$product) {
            return redirect()->route('products.index')->with('message', 'Producto no creado');
        }
        return redirect()->route('products.index')->with('message', 'Producto creado correctamente');
    }

    public function showEdit(int $id): InertiaResponse
    {
        $product = $this->productRepository->getById($id);
        $categories = $this->categoryRepository->getAll();
        return Inertia::render('products/showEdit', [
            'product' => $product,
            'categories' => $categories
        ]);
    }

    public function update(Request $request, int $id): RedirectResponse
    {


        $validated = $request->validate([
            'Nombre' => 'required|string|max:255',
            'Descripcion' => 'required|string',
            'Precio' => 'required|numeric|min:0.01',
            'Stock' => 'required|integer|min:0',
            'Imagen' => 'required|string',
            'CategoriaId' => 'required|integer|exists:categorias,CategoriaId'
        ]);

        print_r($validated);

        $updated = $this->productRepository->update($id, $validated);

        if (!$updated) {
            return redirect()->route('products.index')->with('message', 'Producto no encontrado');
        }

        return redirect()->route('products.index')->with('message', 'Product actualizado correctamente');
    }

    public function destroy(int $id): RedirectResponse
    {
        $deleted = $this->productRepository->delete($id);

        if (!$deleted) {
            return redirect()->route('products.index')->with('message', 'Producto no encontrado');
        }

        return redirect()->route('products.index')->with('message', 'Producto eliminado correctamente');
    }
}
