<?php

namespace Repositories;

require_once __DIR__ . '/../vendor/autoload.php';

use PDO;
use Exception;
use Interfaces\BrandSizeRepositoryInterface;
use Models\BrandSize;

class BrandSizeRepository implements BrandSizeRepositoryInterface
{
  private $connection;
  public function __construct(PDO $connection)
  {
    $this->connection = $connection;
  }
  public function getAll(): array
  {
    $query = "SELECT mt.MarcaId, mt.TamanoId, t.Descripcion as DescTamano, m.Nombre as NombreMarca
                  FROM marca_tamano mt
                  JOIN tamanos t ON mt.TamanoId = t.TamanoId 
                  JOIN marcas m ON mt.MarcaId = m.MarcaId;";

    $result = $this->connection->query($query);
    $brandSizes = array();
    if ($result->rowCount() > 0) {
      while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        $brandSizes[] = $row;
      }
    }

    return $brandSizes;
  }

  public function getByBrandId(int $brandId): array
  {
    $query = "SELECT mt.*, t.Descripcion as DescTamano
               FROM marca_tamano mt
               JOIN tamanos t ON mt.TamanoId = t.TamanoId 
               WHERE mt.MarcaId = :brandId";

    $dbQuery = $this->connection->prepare($query);
    $dbQuery->bindParam(':brandId', $brandId, PDO::PARAM_INT);
    $dbQuery->execute();
    $brandSizes = $dbQuery->fetchAll(PDO::FETCH_ASSOC);

    return  $brandSizes ?? [];
  }

  public function create(BrandSize $data): bool
  {
    $brandId = $data->brandId;
    $sizeId = $data->sizeId;

    if (empty($brandId) || empty($sizeId)) {
      throw new Exception("Todos los campos son obligatorios y deben ser válidos.");
    }
    $query = "INSERT INTO marca_tamano (MarcaId, TamanoId) 
              VALUES (:brandId, :sizeId)";

    $dbQuery = $this->connection->prepare($query);
    $dbQuery->bindParam(':brandId', $brandId, PDO::PARAM_INT);
    $dbQuery->bindParam(':sizeId', $sizeId, PDO::PARAM_INT);
    return $dbQuery->execute();
  }
}
