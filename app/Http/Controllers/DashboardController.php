<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Interfaces\ProductRepositoryInterface;
use App\Interfaces\CategoryRepositoryInterface;
use App\Interfaces\OrderRepositoryInterface;
use Inertia\Inertia;
use Inertia\Response as InertiaResponse;


class DashboardController extends Controller
{
    protected $productRepository;
    protected $categoryRepository;
    protected $orderRepository;

    public function __construct(ProductRepositoryInterface $productRepository, CategoryRepositoryInterface $categoryRepository, OrderRepositoryInterface $orderRepository)
    {
        $this->productRepository = $productRepository;
        $this->categoryRepository = $categoryRepository;
        $this->orderRepository = $orderRepository;
    }

    public function index(): InertiaResponse
    {
        $products = $this->productRepository->getAll();
        $categories = $this->categoryRepository->getAll();
        $orders = $this->orderRepository->getAll();

        return Inertia::render('dashboard', [
            'products' => $products,
            'categories' => $categories,
            'orders' => $orders
        ]);
    }
}
