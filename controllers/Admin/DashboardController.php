<?php

namespace Controllers\Admin;

use Interfaces\AuthenticationServicieInterface;
use Interfaces\CategoryServiceInterface;
use Interfaces\CloudinaryServiceInterface;
use Interfaces\ProductServiceInterface;
use Interfaces\ProviderServiceInterface;
use Interfaces\BrandServiceInterface;
use Interfaces\BrandSizeServiceInterface;
use Models\Product;
use Models\Category;

class DashboardController
{
  private $categoryService;
  private $productService;
  private $cloudinaryService;
  private $authenticationService;
  private $providerService;
  private $brandService;
  private $brandSizeService;
  public function __construct(CategoryServiceInterface $categoryService, ProductServiceInterface $productService, CloudinaryServiceInterface $cloudinaryService, AuthenticationServicieInterface $authenticationService, ProviderServiceInterface $providerService, BrandServiceInterface $brandService, BrandSizeServiceInterface $brandSizeService)
  {
    $this->categoryService = $categoryService;
    $this->productService = $productService;
    $this->cloudinaryService = $cloudinaryService;
    $this->authenticationService = $authenticationService;
    $this->providerService = $providerService;
    $this->brandService = $brandService;
    $this->brandSizeService = $brandSizeService;
  }

  public function showDashboard()
  {
    if (!$this->authenticationService->isAuthenticated()) {
      echo "<script>alert('Solo el administrador puede acceder a esta página');
      
      window.location.href = '/apps/theowl/public/admin';
      </script>";

      exit;
    }

    $categories = $this->categoryService->findAll();
    $products = $this->productService->findAll();

    require __DIR__ . '/../../views/admin/dashboard.php';
  }

  public function showCreate()
  {
    if (!$this->authenticationService->isAuthenticated()) {
      echo "<script>alert('Solo el administrador puede acceder a esta página');
      
      window.location.href = '/apps/theowl/public/admin';
      </script>";

      exit;
    }

    $table = $_GET['identifier'] ?? 'products';

    switch ($table) {
      case "products":
        $categories = $this->categoryService->findAll();
        require __DIR__ . '/../../views/admin/create-product.php';
        break;
      case "categories":
        require __DIR__ . '/../../views/admin/create-category.php';
        break;
      case "providers":
        require __DIR__ . '/../../views/admin/create-provider.php';
        break;
      case "brands":
        require __DIR__ . '/../../views/admin/create-brand.php';
        break;
    }
  }


  public function showEdit()
  {
    if (!$this->authenticationService->isAuthenticated()) {
      echo "<script>alert('Solo el administrador puede acceder a esta página');
      
      window.location.href = '/apps/theowl/public/admin';
      </script>";

      exit;
    }

    $tableToEdit = $_GET['identifier'] ?? 'products';


    switch ($tableToEdit) {
      case "products":
        $id = $_GET['id'] ?? null;
        $product = $this->productService->find($id);
        $categories = $this->categoryService->findAll();

        if (!$product) {
          require_once __DIR__ . '/../../views/error/404.php';
          exit;
        }
        require __DIR__ . '/../../views/admin/edit-product.php';
        break;
      case "categories":
        $id = $_GET['id'] ?? null;
        $category = $this->categoryService->find($id);
        if (!$category) {
          require_once __DIR__ . '/../../views/error/404.php';
          exit;
        }
        require __DIR__ . '/../../views/admin/edit-category.php';
        break;
      case "providers":
        $id = $_GET['id'] ?? null;
        $provider = $this->providerService->find($id);

        if (!$provider) {
          require_once __DIR__ . '/../../views/error/404.php';
          exit;
        }
        require __DIR__ . '/../../views/admin/edit-provider.php';

      case "brands":
        $id = $_GET['id'] ?? null;
        $brand = $this->brandService->find($id);
        $brandSizes = $this->brandSizeService->findAll();
        if (!$brand) {
          require_once __DIR__ . '/../../views/error/404.php';
          exit;
        }
        require __DIR__ . '/../../views/admin/edit-brand.php';
    }
  }



}
