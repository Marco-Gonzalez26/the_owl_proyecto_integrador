<?php

namespace Controllers;

use Interfaces\CategoryServiceInterface;
use Interfaces\ProductServiceInterface;
use Models\Product;
use Models\Category;

class CatalogController
{
  private $categoryService;
  private $productService;

  public function __construct(CategoryServiceInterface $categoryService, ProductServiceInterface $productService)
  {
    $this->categoryService = $categoryService;
    $this->productService = $productService;
  }

  public function showCatalog()
  {
    $categories = $this->categoryService->findAll();
    $products = $this->productService->findAll();

    require __DIR__ . '/../views/products/list.php';
  }
}
