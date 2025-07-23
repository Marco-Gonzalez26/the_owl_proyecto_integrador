<?php

namespace Interfaces;



interface CartRepositoryInterface
{
  public function getCart(): array;
  public function saveCart(array $cart): void;
  public function clearCart(): void;
}
