<?php

namespace Repositories;

require_once __DIR__ . '/../vendor/autoload.php';

use PDO;
use Exception;
use Interfaces\BrandRepositoryInterface;
use Models\Brand;

class BrandRepository implements BrandRepositoryInterface
{
  private $connection;
  public function __construct(PDO $connection)
  {
    $this->connection = $connection;
  }
  public function getAll(): array
  {
    $query = "SELECT b.MarcaId, b.Nombre, b.Estado
                  FROM marcas b;";

    $result = $this->connection->query($query);
    $brands = array();
    if ($result->rowCount() > 0) {
      while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        $brands[] = $row;
      }
    }
    return $brands;
  }

  public function getById(int $id): array
  {
    $query = "SELECT m.*
               FROM marcas m
               WHERE m.MarcaId = :marcaId";

    $dbQuery = $this->connection->prepare($query);
    $dbQuery->bindParam(':marcaId', $id, PDO::PARAM_INT);
    $dbQuery->execute();
    $brand = $dbQuery->fetch(PDO::FETCH_ASSOC);

    return  $brand ?? [];
  }

  public function create(Brand $data): int
  {
    $name = $data->name;
    $state = 1;

    if (empty($name) || empty($state)) {
      throw new Exception("Todos los campos son obligatorios y deben ser válidos.");
    }
    $query = "INSERT INTO marcas (Nombre, Estado) 
              VALUES (:name, :state)";

    $dbQuery = $this->connection->prepare($query);
    $dbQuery->bindParam(':name', $name, PDO::PARAM_STR);
    $dbQuery->bindParam(':state', $state, PDO::PARAM_STR);
    $dbQuery->execute();
    return (int) $this->connection->lastInsertId();
  }

  public function update(int $id, Brand $data): bool
  {
    $name = $data->name;
    $state = $data->state;

    if (empty($name) || empty($state)) {
      return false;
    }

    $query = "UPDATE marcas SET Nombre = :name, Estado = :state WHERE MarcaId = :marcaId";

    $dbQuery = $this->connection->prepare($query);
    $dbQuery->bindParam(':name', $name, PDO::PARAM_STR);
    $dbQuery->bindParam(':state', $state, PDO::PARAM_STR);
    $dbQuery->bindParam(':marcaId', $id, PDO::PARAM_INT);
    return $dbQuery->execute();
  }

  public function delete(int $id): bool
  {
    $query = "UPDATE marcas SET Estado = 0 WHERE MarcaId = :marcaId";
    $dbQuery = $this->connection->prepare($query);
    $dbQuery->bindParam(':marcaId', $id, PDO::PARAM_INT);
    return $dbQuery->execute();
  }
}
