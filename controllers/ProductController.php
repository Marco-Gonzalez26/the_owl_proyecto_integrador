<?php

class ProductController
{
  private $productRepository;
  private $errorHandler;


  public function __construct(ProductRepository $productRepository, ViewsErrorHandler $errorHandler)
  {

    $this->productRepository = $productRepository;
    $this->errorHandler = $errorHandler;
  }


  public function showProductById($productId)
  {
    try {
      $product = $this->productRepository->getProductById($productId);
      if (!$product) {
        $this->errorHandler->handleNotFound();
        return;
      }

      return $product;
    } catch (Exception $e) {
      error_log($e->getMessage());
      $this->errorHandler->handleInternalServerError();
      return;
    }
  }

  public function listAllProducts()
  {
    try {
      $products = $this->productRepository->getAllProducts();
      return $products;
    } catch (Exception $e) {
      error_log($e->getMessage());
    }
  }

  public function createProduct($name, $description, $price, $stock, $imageUrl, $categoryId)
  {
    try {
      if ($this->productRepository->insertProduct($name, $description, $price, $stock, $imageUrl, $categoryId)) {
        return true;
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
      if ($this->productRepository->updateProduct($productId, $name, $description, $price, $stock, $imageUrl, $categoryId)) {
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
      if ($this->productRepository->deleteProduct($productId)) {
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
