<?php

namespace Controllers;

use Interfaces\CategoryServiceInterface;

class CategoryController
{

  private $service;
  public function __construct(CategoryServiceInterface $service)
  {
    $this->service = $service;
  }

  public function showAll()
  {
    $categories = $this->service->findAll();
    require __DIR__ . '/../views/categories/list.php';
  }

  public function getCategoryById($categoryId)
  {
    $category = $this->service->find($categoryId);
    require __DIR__ . '/../views/categories/detail.php';
  }
}
