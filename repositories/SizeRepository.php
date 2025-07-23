<?php

namespace Repositories;

require_once __DIR__ . '/../vendor/autoload.php';

use PDO;
use Exception;
use Interfaces\SizeRepositoryInterface;
use Models\Size;

class SizeRepository implements SizeRepositoryInterface
{
  private $connection;
  public function __construct(PDO $connection)
  {
    $this->connection = $connection;
  }
  public function getAll(): array
  {
    $query = "SELECT s.TamanoId, s.Descripcion
                  FROM tamanos s;";

    $result = $this->connection->query($query);
    $sizes = array();
    if ($result->rowCount() > 0) {
      while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        $sizes[] = $row;
      }
    }
    return $sizes;
  }

  public function getById(int $id): array
  {
    $query = "SELECT s.*, t.Descripcion
               FROM tamanos s
               JOIN marcas t ON s.MarcaId = t.MarcaId
               WHERE s.TamanoId = :tamanoId";

    $dbQuery = $this->connection->prepare($query);
    $dbQuery->bindParam(':tamanoId', $id, PDO::PARAM_INT);
    $dbQuery->execute();
    $size = $dbQuery->fetch(PDO::FETCH_ASSOC);

    return  $size ?? [];
  }

  public function create(Size $data): int
  {
    $description = $data->description;

    if (empty($description)) {
      throw new Exception("Todos los campos son obligatorios y deben ser válidos.");
    }
    $query = "INSERT INTO tamanos (Descripcion) 
              VALUES (:description)";

    $dbQuery = $this->connection->prepare($query);
    $dbQuery->bindParam(':description', $description, PDO::PARAM_STR);
    $dbQuery->execute();
    return (int) $this->connection->lastInsertId();
  }

  public function update(int $id, Size $data): bool
  {
    $description = $data->description;

    if (empty($description)) {
      return false;
    }
    $query = "UPDATE tamanos SET Descripcion = :description WHERE TamanoId = :tamanoId";

    $dbQuery = $this->connection->prepare($query);
    $dbQuery->bindParam(':description', $description, PDO::PARAM_STR);
    $dbQuery->bindParam(':tamanoId', $id, PDO::PARAM_INT);
    return $dbQuery->execute();
  }

  public function delete(int $id): bool
  {
    $query = "UPDATE tamanos SET Estado = 0 WHERE TamanoId = :tamanoId";
    $dbQuery = $this->connection->prepare($query);
    $dbQuery->bindParam(':tamanoId', $id, PDO::PARAM_INT);
    return $dbQuery->execute();
  }
}
