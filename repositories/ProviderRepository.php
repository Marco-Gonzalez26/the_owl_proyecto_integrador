<?php

namespace Repositories;

require_once __DIR__ . '/../vendor/autoload.php';

use PDO;
use Exception;
use Interfaces\ProviderRepositoryInterface;
use Models\Provider;

class ProviderRepository implements ProviderRepositoryInterface
{
  private $connection;
  public function __construct(PDO $connection)
  {
    $this->connection = $connection;
  }
  public function getAll(): array
  {
    $query = "SELECT p.ProveedorId, p.Nombre, p.Estado
                  FROM proveedores p;";

    $result = $this->connection->query($query);
    $providers = array();
    if ($result->rowCount() > 0) {
      while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        $providers[] = $row;
      }
    }
    return $providers;
  }

  public function getById(int $id): array
  {
    $query = "SELECT p.*
               FROM proveedores p 
               WHERE p.ProveedorID = :proveedorId";

    $dbQuery = $this->connection->prepare($query);
    $dbQuery->bindParam(':proveedorId', $id, PDO::PARAM_INT);
    $dbQuery->execute();
    $provider = $dbQuery->fetch(PDO::FETCH_ASSOC);

    return  $provider ?? [];
  }

  public function create(Provider $data): bool
  {
    $name = $data->name;
    $state = $data->state;

    if (empty($name) || empty($state)) {
      throw new Exception("Todos los campos son obligatorios y deben ser válidos.");
    }
    $query = "INSERT INTO proveedores (Nombre, Estado) 
              VALUES (:name, :state)";

    $dbQuery = $this->connection->prepare($query);
    $dbQuery->bindParam(':name', $name, PDO::PARAM_STR);
    $dbQuery->bindParam(':state', $state, PDO::PARAM_STR);
    return $dbQuery->execute();
  }

  public function update(int $id, Provider $data): bool
  {
    $name = $data->name;
    $state = $data->state;

    if (empty($name) || empty($state)) {
      return false;
    }

    $query = "UPDATE proveedores SET Nombre = :name, Estado = :state WHERE ProveedorId = :proveedorId";

    $dbQuery = $this->connection->prepare($query);
    $dbQuery->bindParam(':name', $name, PDO::PARAM_STR);
    $dbQuery->bindParam(':state', $state, PDO::PARAM_STR);
    $dbQuery->bindParam(':proveedorId', $id, PDO::PARAM_INT);
    return $dbQuery->execute();
  }

  public function delete(int $id): bool
  {
    $query = "UPDATE proveedores SET Estado = 0 WHERE ProveedorId = :proveedorId";
    $dbQuery = $this->connection->prepare($query);
    $dbQuery->bindParam(':proveedorId', $id, PDO::PARAM_INT);
    return $dbQuery->execute();
  }
}
