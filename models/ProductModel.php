<?php

class Product
{
  public function __construct(
    public $name,
    public $description,
    public $price,
    public $productId,
    public $categoryId,
    public $stock,
    public $imageUrl
  ) {}
}
