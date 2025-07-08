<?php

namespace Repositories;

require_once __DIR__ . '/../vendor/autoload.php';


use PDO;
use Exception;
use Interfaces\CategoryRepositoryInterface;
use Models\Category;

class CategoryRepository implements CategoryRepositoryInterface
{
  private $connection;
  public function __construct(PDO $connection)
  {
    $this->connection = $connection;
  }
  public function getAll(): array
  {
    $query = "SELECT CategoriaId, Nombre FROM Categorias WHERE Estado = 1 ORDER BY Nombre";
    $categories = $this->connection->query($query);
    return $categories->fetchAll(PDO::FETCH_ASSOC);
  }

  public function getById(int $id): array
  {
    $query = "SELECT CategoriaId, Nombre FROM Categorias WHERE CategoriaId = :categoryId";
    $dbQuery = $this->connection->prepare($query);
    $dbQuery->bindParam(':categoryId', $id, PDO::PARAM_INT);
    $dbQuery->execute();
    $category = $dbQuery->fetch(PDO::FETCH_ASSOC);
    return $category;
  }

  public function create(Category $data): bool
  {
    $name = $data->name;
    $description = $data->description;

    if (empty($name) || empty($description)) {
      throw new Exception("Todos los campos son obligatorios y deben ser válidos.");
    }
    $query = "INSERT INTO categorias (Nombre, Descripcion)
              VALUES (:name, :description)";

    $dbQuery = $this->connection->prepare($query);
    $dbQuery->bindParam(':name', $name, PDO::PARAM_STR);
    $dbQuery->bindParam(':description', $description, PDO::PARAM_STR);
    return $dbQuery->execute();
  }

  public function update(int $id, Category $data): bool
  {
    $name = $data->name;
    $description = $data->description;

    if (empty($name) || empty($description)) {
      throw new Exception("Todos los campos son obligatorios y deben ser válidos.");
    }

    $query = "UPDATE categorias SET Nombre = :name, Descripcion = :description WHERE CategoriaId = :categoryId";

    $dbQuery = $this->connection->prepare($query);
    $dbQuery->bindParam(':name', $name, PDO::PARAM_STR);
    $dbQuery->bindParam(':description', $description, PDO::PARAM_STR);
    $dbQuery->bindParam(':categoryId', $id, PDO::PARAM_INT);
    return $dbQuery->execute();
  }

  public function delete(int $id): bool
  {

    $query = "DELETE FROM categorias WHERE CategoriaId = :categoryId";

    $dbQuery = $this->connection->prepare($query);
    $dbQuery->bindParam(':categoryId', $id, PDO::PARAM_INT);

    return $dbQuery->execute();
  }
}
