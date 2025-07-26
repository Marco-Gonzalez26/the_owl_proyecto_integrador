<?php

namespace Controllers\Admin;

use Interfaces\CategoryServiceInterface;
use Models\Category;

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
  public function showCreateCategory()
  {


    require __DIR__ . '/../../views/admin/create-category.php';
  }

  public function showEditCategory()
  {
    $categoryId = $_GET['id'] ?? null;

    $category = $this->categoryService->find($categoryId);

    require __DIR__ . '/../../views/admin/edit-category.php';
  }
  public function createCategory()
  {


    $name = $_POST['nombre'] ?? null;

    if (!$name) {
    }

    if ($this->categoryService->create(new Category($name))) {
      echo "<script>alert('Categoria creada con éxito');

      window.location.href = '/apps/theowl/public/admin/dashboard'
    </script>";
    };
  }

  public function editCategory()
  {


    $categoryId = $_GET['categoryId'] ?? null;
    $name = $_POST['nombre'] ?? null;

    if (!$name || !$categoryId) {
    }

    if ($this->categoryService->update($categoryId, new Category($name))) {
      echo "<script>alert('Categoria actualizada con éxito');

      window.location.href = '/apps/theowl/public/admin/dashboard'
    </script>";
    };
  }
  public function deleteCategory()
  {
    $categoryId = $_GET['categoryId'] ?? null;

    if (!$categoryId) {
      echo "<script>alert('ID de categoria no proporcionado'); 
    window.location.href = '/apps/theowl/public/admin/dashboard?error=true';
  </script>";
      exit;
    }

    if ($this->categoryService->delete($categoryId)) {
      echo "<script>alert('Categoria eliminada con éxito'); 
    window.location.href = '/apps/theowl/public/admin/dashboard?success=true';
  </script>";
    }
  }
}
