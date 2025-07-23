<?php

namespace Controllers\Admin;

use Interfaces\CategoryServiceInterface;

class CategoriesAdminController
{
  private $categoryService;
  public function __construct(CategoryServiceInterface $categoryService)
  {
    $this->categoryService = $categoryService;
  }

  public function showAdminCategories()
  {
    $categories = $this->categoryService->findAll();

    require __DIR__ . '/../../views/admin/categories.php';
  }
}
