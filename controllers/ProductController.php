<?php

namespace Controllers;

use Interfaces\ProductServiceInterface;
use Models\Product;

class ProductController
{
  private $service;
  private $errorHandler;


  public function __construct(ProductServiceInterface $service)
  {

    $this->service = $service;
  }


  public function showProductById($productId)
  {
    $product = $this->service->find($productId);
    require __DIR__ . '/../views/products/detail.php';
  }

  public function showAllProducts()
  {
    $products = $this->service->findAll();
    require __DIR__ . '/../views/products/list.php';
  }

  public function createProduct($name, $description, $price, $stock, $imageUrl, $categoryId)
  {
    $productToAdd = new Product($name, $description, $price, $categoryId, $stock, $imageUrl);

    $this->service->create($productToAdd);
    header("Location:/admin/products");
  }

  public function updateProduct($productId, $name, $description, $price, $stock, $imageUrl, $categoryId)
  {
    $productToUpdate = new Product($name, $description, $price, $categoryId, $stock, $imageUrl);

    $this->service->update($productId, $productToUpdate);
    header("Location:/admin/products");
  }
  public function deleteProduct($productId)
  {
    $this->service->delete($productId);
    header("Location:/admin/products");
  }
}
