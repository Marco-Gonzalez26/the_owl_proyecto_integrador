<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\EditProductRequest;
use App\Http\Requests\StoreProductRequest;
use App\Interfaces\BrandRepositoryInterface;
use App\Interfaces\CategoryRepositoryInterface;
use App\Interfaces\ProductRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response as InertiaResponse;
use App\Interfaces\CloudinaryServiceInterface;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
    protected $productRepository;
    protected $categoryRepository;
    protected $brandRepository;
    protected $brandSizeRepository;

    protected $cloudinaryService;

    public function __construct(ProductRepositoryInterface $productRepository, CategoryRepositoryInterface $categoryRepository, CloudinaryServiceInterface $cloudinaryService, BrandRepositoryInterface $brandRepository)
    {
        $this->productRepository = $productRepository;
        $this->categoryRepository = $categoryRepository;
        $this->cloudinaryService = $cloudinaryService;
        $this->brandRepository = $brandRepository;
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
        $brands = $this->brandRepository->getAll();
        return Inertia::render('products/showCreate', ["categories" => $categories, "brands" => $brands]);
    }
    public function store(StoreProductRequest $request): RedirectResponse
    {
        $image = $request->file('Imagen');
        $imageUrl = $this->cloudinaryService->uploadFile($image);
        $validated = $request->validated();

        $productToCreate = [
            'Nombre' => $validated["Nombre"],
            'Descripcion' => $validated["Descripcion"],
            'Precio' => $validated["Precio"],
            'Stock' => $validated["Stock"],
            'Imagen' => $imageUrl,
            'CategoriaId' => $validated["CategoriaId"],
            'PrecioMayorista' => $validated["PrecioMayorista"],
            "MarcaId" => $validated["MarcaId"],
            "TamanoId" => $validated["TamanoId"],
            "MinimoMayorista" => $validated["MinimoMayorista"]

        ];
        Log::info('Producto a crear', ['product' => $productToCreate]);
        $product = $this->productRepository->create($productToCreate);

        if (!$product) {
            return redirect()->route('dashboard')->with('message', 'Producto no creado');
        }
        return redirect()->route('dashboard')->with('message', 'Producto creado correctamente');
    }

    public function showEdit(int $id): InertiaResponse
    {
        $product = $this->productRepository->getById($id);
        $categories = $this->categoryRepository->getAll();
        $brands = $this->brandRepository->getAll();
        return Inertia::render('products/showEdit', [
            'product' => $product,
            'categories' => $categories,
            "brands" => $brands
        ]);
    }

    public function update(EditProductRequest $request, int $id): RedirectResponse
    {


        $validated = $request->validated();

        print_r($validated);

        $updated = $this->productRepository->update($id, $validated);

        if (!$updated) {
            return redirect()->back()->with('message', 'Producto no encontrado');
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
