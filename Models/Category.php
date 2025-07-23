<?php

namespace Models;

class Category
{
  public $name;
  public $id;
  public function __construct(string $name, ?int $categoryId = null)
  {
    $this->name = $name;
    $this->id = $categoryId;
  }
}
