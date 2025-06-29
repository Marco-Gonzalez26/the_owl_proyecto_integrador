<?php
require_once BASE_PATH . '/models/CategoryModel.php';
class CategoryController
{
  private $categoryModel;

  public function __construct()
  {
    $this->categoryModel = new CategoryModel();
  }

  public function getAllCategories()
  {
    $categories = $this->categoryModel->getAllCategories();
    return $categories;
  }

  public function getCategoryById($categoryId)
  {
    $category = $this->categoryModel->getCategoryById($categoryId);
    return $category;
  }
}
