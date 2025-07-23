<?php

namespace Models;

class Product
{
  public $name;
  public  $description;
  public  $price;
  public  $categoryId;
  public  $stock;
  public  $imageUrl;

  public function __construct(
    string $name,
    string $description,
    int $price,
    int $categoryId,
    int $stock,
    string $imageUrl,
    ?int $productId = null
  ) {
    $this->name = $name;
    $this->description = $description;
    $this->price = $price;
    $this->categoryId = $categoryId;
    $this->stock = $stock;
    $this->imageUrl = $imageUrl;
  }
}
