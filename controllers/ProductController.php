<?php
require_once 'models/ProductModel.php';
class ProductController
{
  private $productoModel;


  public function __construct()
  {

    $this->productoModel = new ProductModel();
  }


  public function showProductById($productId)
  {
    try {
      $product = $this->productoModel->getProductById($productId);
      if (!$product) {
        require 'views/error/404.php';
        return;
      }

      return $product;
    } catch (Exception $e) {
      error_log($e->getMessage());
      require 'views/error/500.php';
      return;
    }
  }

  public function listAllProducts()
  {
    try {
      $products = $this->productoModel->getAllProducts();
      return $products;
    } catch (Exception $e) {
      error_log($e->getMessage());
    }
  }

  public function createProduct($name, $description, $price, $stock, $imageUrl, $categoryId)
  {
    try {
      if ($this->productoModel->insertProduct($name, $description, $price, $stock, $imageUrl, $categoryId)) {
        return ['ProductoId' => $this->productoModel->productId];
      } else {
        return false;
      }
    } catch (Exception $e) {
      // Log the error message
      error_log($e->getMessage());
      echo "<script>alert('Error al crear el producto: " . $e->getMessage() . "');</script>";
      return false;
    }
  }

  public function updateProduct($productId, $name, $description, $price, $stock, $imageUrl, $categoryId)
  {
    try {
      if ($this->productoModel->updateProduct($productId, $name, $description, $price, $stock, $imageUrl, $categoryId)) {
        return ['ProductoId' => $productId];
      } else {
        return false;
      }
    } catch (Exception $e) {
      // Log the error message
      error_log($e->getMessage());
      echo "<script>alert('Error al actualizar el producto: " . $e->getMessage() . "');</script>";
      return false;
    }
  }
  public function deleteProduct($productId)
  {
    try {
      if ($this->productoModel->deleteProduct($productId)) {
        return true;
      } else {
        return false;
      }
    } catch (Exception $e) {
      // Log the error message
      error_log($e->getMessage());
      echo "<script>alert('Error al eliminar el producto: " . $e->getMessage() . "');</script>";
      return false;
    }
  }
}
