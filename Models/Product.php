<?php

namespace Models;

class Product
{
  public function __construct(
    string $name,
    string $description,
    int $price,
    int $categoryId,
    int $stock,
    string $imageUrl,
    ?int $productId = null
  ) {}
}
