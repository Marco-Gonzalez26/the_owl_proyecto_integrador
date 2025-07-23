<?php

namespace Controllers;

use Interfaces\ProductServiceInterface;

class ProductController
{
  private $service;


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
    $categories = $this->service->findAll();
    require __DIR__ . '/../views/products/list.php';
  }
}
