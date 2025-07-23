<?php

namespace Controllers;

require_once __DIR__ . '/../vendor/autoload.php';

use Services\CartService;
use JsonEncode;

class CartController
{
  private $cartService;

  public function __construct(CartService $cartService)
  {
    $this->cartService = $cartService;
  }

  public function addProduct(): bool
  {
    $productId = $_POST['product_id'];
    $name = $_POST['name'];
    $price = $_POST['price'];
    $quantity = $_POST['quantity'];
    $imageUrl = $_POST['image_url'];
    return $this->cartService->addProduct($productId, $name, $price, $quantity ?? 1, $imageUrl);
  }

  public function deleteProduct(): bool
  {
    $productId = $_POST['productId'];
    return $this->cartService->deleteProduct($productId);
  }

  public function getCart()
  {
    header('Content-Type: application/json');
    $cart = $this->cartService->getCart();
    echo json_encode($cart, JSON_PRETTY_PRINT);
    exit;
  }

  public function saveCart()
  {
    $cartToSave = json_decode($_POST['cart']);

    $this->cartService->saveCart($cartToSave);
    header('Content-Type: application/json');
    echo json_encode($cartToSave, JSON_PRETTY_PRINT);
  }
}
