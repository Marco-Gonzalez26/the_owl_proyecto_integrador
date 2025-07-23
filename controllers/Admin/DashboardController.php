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
  public function createProduct()
  {

    if (!$this->authenticationService->isAuthenticated()) {
      echo "<script>alert('Solo el administrador puede acceder a esta página');
      
      window.location.href = '/apps/theowl/public/admin';
      </script>";

      exit;
    }

    if (isset($_POST['nombre']) && isset($_POST['descripcion']) && isset($_POST['precio']) && isset($_POST['stock']) && isset($_FILES['imagen']) && isset($_POST['categoria'])) {
      $name = $_POST['nombre'];
      $description = $_POST['descripcion'];
      $price = $_POST['precio'] ?? 0;
      $stock = $_POST['stock'] ?? 0;
      $image = $_FILES['imagen'];
      $categoryId = $_POST['categoria'] ?? null;
      $imageUrl = $this->cloudinaryService->uploadImage($image['tmp_name']);
      $productToAdd = new Product($name, $description, $price,  $categoryId, $stock, $imageUrl);


      $product = $this->productService->create($productToAdd);
      if ($product) {
        echo "<script>alert('Producto creado con éxito'); 
      window.location.href = '/apps/theowl/public/admin/dashboard?success=true';
    </script>";
      } else {
        echo "<script>alert('Error al crear el producto');
      </script>";
      }
    } else {
      echo "<script>alert('Por favor, complete todos los campos');</script>";
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

  public function editProduct()
  {
    if (!$this->authenticationService->isAuthenticated()) {
      echo "<script>alert('Solo el administrador puede acceder a esta página');
      
      window.location.href = '/apps/theowl/public/admin';
      </script>";

      exit;
    }

    $productId = $_GET['productId'] ?? null;

    if (!$productId) {
      echo "<script>alert('ID de producto no proporcionado'); 
    window.location.href = '/apps/theowl/admin/dashboard?error=true';
  </script>";
      exit;
    }

    $product = $this->productService->find($productId);

    if (!$product) {
      echo "<script>alert('Producto no encontrado'); 
    window.location.href = '/apps/theowl/public/admin/dashboard?error=true';
  </script>";
    }

    $productImageUrl = $product['Imagen'];

    if (isset($_POST['nombre']) && isset($_POST['descripcion']) && isset($_POST['precio']) && isset($_POST['stock']) && isset($_POST['categoria'])) {
      // Recieve form data
      $name = $_POST['nombre'];
      $description = $_POST['descripcion'];
      $price = $_POST['precio'];
      $stock = $_POST['stock'];
      $categoryId = $_POST['categoria'] ?? null;

      if ($_FILES['imagen']['tmp_name']) {
        // Validate form data
        $image = $_FILES['imagen'];
        $imageUrl = $this->cloudinaryService->uploadImage($image['tmp_name']) ?? $productImageUrl;
      } else {
        // If no new image is uploaded, keep the old image URL
        $imageUrl = $productImageUrl;
      }
      $productToEdit = new Product($name, $description, $price,  $categoryId, $stock, $imageUrl);

      $product = $this->productService->update($productId,  $productToEdit);

      if ($product) {
        echo "<script>alert('Producto actualizado con éxito'); 
      window.location.href = '/apps/theowl/public/admin/dashboard?success=true';
    </script>";
      } else {
        echo "<script>alert('Error al actualizar el producto');
      </script>";
      }
    } else {
      echo "<script>alert('Por favor, complete todos los campos');</script>";
    }
  }

  public function deleteProduct()
  {
    if (!$this->authenticationService->isAuthenticated()) {
      echo "<script>alert('Solo el administrador puede acceder a esta página');
      
      window.location.href = '/apps/theowl/public/admin';
      </script>";

      exit;
    }

    $productId = $_GET['productId'] ?? null;

    if (!$productId) {
      echo "<script>alert('ID de producto no proporcionado'); 
    window.location.href = '/apps/theowl/public/admin/dashboard?error=true';
  </script>";
      exit;
    }

    if ($this->productService->delete($productId)) {
      echo "<script>alert('Producto eliminado con éxito'); 
    window.location.href = '/apps/theowl/public/admin/dashboard?success=true';
  </script>";
    }
  }

  public function createCategory()
  {
    if (!$this->authenticationService->isAuthenticated()) {
      echo "<script>alert('Solo el administrador puede acceder a esta página');
      
      window.location.href = '/apps/theowl/public/admin';
      </script>";

      exit;
    }

    $name = $_POST['nombre'] ?? null;

    if (!$name) {
    }

    if ($this->categoryService->create(new Category($name))) {
      echo "<script>alert('Categoria creada con éxito');

      window.location.href = '/apps/theowl/public/admin/dashboard'
    </script>";
    };
  }

  public function editCategory()
  {
    if (!$this->authenticationService->isAuthenticated()) {
      echo "<script>alert('Solo el administrador puede acceder a esta página');
      
      window.location.href = '/apps/theowl/public/admin';
      </script>";

      exit;
    }

    $categoryId = $_GET['categoryId'] ?? null;
    $name = $_POST['nombre'] ?? null;

    if (!$name || !$categoryId) {
    }

    if ($this->categoryService->update($categoryId, new Category($name))) {
      echo "<script>alert('Categoria actualizada con éxito');

      window.location.href = '/apps/theowl/public/admin/dashboard'
    </script>";
    };
  }
  public function deleteCategory()
  {
    if (!$this->authenticationService->isAuthenticated()) {
      echo "<script>alert('Solo el administrador puede acceder a esta página');
      
      window.location.href = '/apps/theowl/public/admin';
      </script>";

      exit;
    }

    $categoryId = $_GET['categoryId'] ?? null;

    if (!$categoryId) {
      echo "<script>alert('ID de categoria no proporcionado'); 
    window.location.href = '/apps/theowl/public/admin/dashboard?error=true';
  </script>";
      exit;
    }

    if ($this->categoryService->delete($categoryId)) {
      echo "<script>alert('Categoria eliminada con éxito'); 
    window.location.href = '/apps/theowl/public/admin/dashboard?success=true';
  </script>";
    }
  }
}
