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
}
