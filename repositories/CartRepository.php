<?php

namespace Repositories;

require_once __DIR__ . '/../vendor/autoload.php';

use Interfaces\CartRepositoryInterface;

class CartRepository implements CartRepositoryInterface
{


  public function getCart(): array
  {
    return $_SESSION['cart'] ?? ['items' => [], 'total' => 0];
  }

  public function saveCart(array $cart): void
  {
    $_SESSION['cart'] = $cart;
  }

  public function clearCart(): void
  {
    unset($_SESSION['cart']);
  }
}
