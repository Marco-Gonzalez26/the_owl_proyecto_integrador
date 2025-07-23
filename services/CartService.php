<?php

namespace Services;

require_once __DIR__ . '/../vendor/autoload.php';

use Interfaces\CartRepositoryInterface;
use Interfaces\SessionCartRepositoryInterface;

class CartService
{
  private $cartRepository;
  public function __construct(CartRepositoryInterface $cartRepository)
  {
    $this->cartRepository = $cartRepository;
  }

  public function addProduct(int $productId, string $name, float $price, int $quantity = 1, string $imageUrl): bool
  {
    $cart = $this->cartRepository->getCart();

    $cart['items'][] = ["productId" => $productId, "name" => $name, "price" => $price, "quantity" => $quantity, "imageUrl" => $imageUrl];


    $cart["total"] = $this->calculateTotal($cart['items']);

    return true;
  }

  public function deleteProduct(int $productId): bool
  {
    $cart = $this->cartRepository->getCart();
    $cart['items'] = array_filter($cart['items'], function ($item) use ($productId) {
      return $item['productId'] !== $productId;
    });
    $cart['total'] = $this->calculateTotal($cart['items']);
    return true;
  }

  public function getCart(): array
  {
    return $this->cartRepository->getCart();
  }

  public function saveCart(array $cart)
  {
    return $this->cartRepository->saveCart($cart);
  }
  private function calculateTotal(array $items): float
  {
    return array_reduce($items, function ($acc, $item) {
      return $acc + $item['price'] * $item['quantity'];
    }, 0);
  }
}
