<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Interfaces\ProductRepositoryInterface;
use App\Interfaces\CategoryRepositoryInterface;
use Inertia\Inertia;
use Inertia\Response as InertiaResponse;


class DashboardController extends Controller
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
        $categories = $this->categoryRepository->getAll();
        return Inertia::render('dashboard', [
            'products' => $products,
            'categories' => $categories
        ]);
    }
}
