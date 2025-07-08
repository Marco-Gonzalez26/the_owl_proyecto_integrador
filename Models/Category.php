<?php

namespace Models;

class Category
{
  public function __construct(public string $name, public string $description, public ?int $categoryId = null) {}
}
