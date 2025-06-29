<?php
require_once BASE_PATH . '/config/db_connection.php';
class CategoryModel
{
  private $connection;
  public $name;
  public $description;
  public $categoryId;

  public function __construct()
  {
    $dbInstance = DbConnection::getInstance();
    $this->connection = $dbInstance->getConnection();
    $this->name = '';
    $this->description = '';
    $this->categoryId = 0;
  }
  public function __destruct()
  {
    $this->connection = null;
  }

  public function getAllCategories()
  {
    $query = "SELECT CategoriaId, Nombre FROM Categorias WHERE Estado = 1 ORDER BY Nombre";
    $categories = $this->connection->query($query);
    return $categories->fetchAll(PDO::FETCH_ASSOC);
  }

  public function getCategoryById($categoryId)
  {
    $query = "SELECT CategoriaId, Nombre FROM Categorias WHERE CategoriaId = :categoryId";
    $dbQuery = $this->connection->prepare($query);
    $dbQuery->bindParam(':categoryId', $categoryId, PDO::PARAM_INT);
    $dbQuery->execute();
    $category = $dbQuery->fetch(PDO::FETCH_ASSOC);
    return $category;
  }
}
