<?php

namespace Models;

class Product
{
  public function __construct(

    public string $name,
    public string $description,
    public int $price,
    public int $categoryId,
    public int $stock,
    public string $imageUrl,
    public ?int $productId = null
  ) {}
}
