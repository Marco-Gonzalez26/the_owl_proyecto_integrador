<?php

namespace Controllers\Admin;

use Interfaces\CategoryServiceInterface;
use Interfaces\ProductServiceInterface;
use Models\Product;
use Services\AuthenticationService;

class ProductAdminController
{
  private $categoryService;
  private $productService;
  private $authenticationService;
  public function __construct(CategoryServiceInterface $categoryService, ProductServiceInterface $productService, AuthenticationService $authenticationService)
  {
    $this->categoryService = $categoryService;
    $this->productService = $productService;
    $this->authenticationService = $authenticationService;
  }

  public function showAdminProducts()
  {

    if (!$this->authenticationService->isAuthenticated()) {
      echo "<script>alert('Solo el administrador puede acceder a esta página');
      
      window.location.href = '/apps/theowl/public/admin';
      </script>";

      exit;
    }

    $categories = $this->categoryService->findAll();
    $products = $this->productService->findAll();

    require __DIR__ . '/../../views/admin/products.php';
  }
}
