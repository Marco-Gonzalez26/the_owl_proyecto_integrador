<?php

namespace Controllers\Admin;

use Interfaces\CategoryServiceInterface;
use Interfaces\CloudinaryServiceInterface;
use Interfaces\ProductServiceInterface;
use Models\Product;
use Services\AuthenticationService;

class ProductAdminController
{
  private $categoryService;
  private $productService;
  private $authenticationService;
  private $cloudinaryService;
  public function __construct(CategoryServiceInterface $categoryService, ProductServiceInterface $productService, AuthenticationService $authenticationService, CloudinaryServiceInterface $cloudinaryService)
  {
    $this->categoryService = $categoryService;
    $this->productService = $productService;
    $this->authenticationService = $authenticationService;
    $this->cloudinaryService = $cloudinaryService;
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

  public function showCreateProduct()
  {
    $categories = $this->categoryService->findAll();

    require __DIR__ . '/../../views/admin/create-product.php';
  }

  public function showEditProduct()
  {
    $productId = $_GET['id'] ?? null;
    $product = $this->productService->find($productId);
    $categories = $this->categoryService->findAll();
    require __DIR__ . '/../../views/admin/edit-product.php';
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


      $response = $this->productService->create($productToAdd);
      if ($response) {
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
}
