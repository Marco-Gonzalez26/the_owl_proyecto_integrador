<?php

namespace Repositories;

require_once __DIR__ . '/../vendor/autoload.php';


use PDO;
use Exception;
use Interfaces\ProductRepositoryInterface;
use Models\Product;

class ProductRepository implements ProductRepositoryInterface
{
  private $connection;
  public function __construct(PDO $connection)
  {
    $this->connection = $connection;
  }
  public function getAll(): array
  {
    $query = "SELECT p.ProductoId, p.Nombre, p.Descripcion, p.Precio, p.Stock, p.Imagen, p.CategoriaId, c.Nombre as NombreCategoria
                  FROM productos p
                  JOIN categorias c ON p.CategoriaId = c.CategoriaId;";

    $result = $this->connection->query($query);
    $products = array();
    if ($result->rowCount() > 0) {
      while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        $products[] = $row;
      }
    } 
    return $products;
  }

  public function getById(int $id): array
  {
    $query = "SELECT p.*, c.Nombre as NombreCategoria
               FROM productos p
               JOIN categorias c ON p.CategoriaId = c.CategoriaId
               WHERE p.ProductoID = :productId";

    $dbQuery = $this->connection->prepare($query);
    $dbQuery->bindParam(':productId', $id, PDO::PARAM_INT);
    $dbQuery->execute();
    $product = $dbQuery->fetch(PDO::FETCH_ASSOC);
    return $product ?: [];
  }

  public function create(Product $data): bool
  {
    $name = $data->name;
    $description = $data->description;
    $price = $data->price;
    $stock = $data->stock;
    $categoryId = $data->categoryId;
    $imageUrl = $data->imageUrl;

    if (empty($name) || empty($description) || $price <= 0 || $stock < 0 || empty($imageUrl) || $categoryId <= 0) {
      throw new Exception("Todos los campos son obligatorios y deben ser válidos.");
    }
    $query = "INSERT INTO productos (Nombre, Descripcion, Precio, Stock, Imagen, CategoriaId) 
              VALUES (:name, :description, :price, :stock, :imageUrl, :categoryId)";

    $dbQuery = $this->connection->prepare($query);
    $dbQuery->bindParam(':name', $name, PDO::PARAM_STR);
    $dbQuery->bindParam(':description', $description, PDO::PARAM_STR);
    $dbQuery->bindParam(':price', $price);
    $dbQuery->bindParam(':stock', $stock, PDO::PARAM_INT);
    $dbQuery->bindParam(':imageUrl', $imageUrl, PDO::PARAM_STR);
    $dbQuery->bindParam(':categoryId', $categoryId, PDO::PARAM_INT);
    return $dbQuery->execute();
  }

  public function update(int $id, Product $data): bool
  {
    $name = $data->name;
    $description = $data->description;
    $price = $data->price;
    $stock = $data->stock;
    $categoryId = $data->categoryId;
    $imageUrl = $data->imageUrl;

    if (empty($name) || empty($description) || $price <= 0 || $stock < 0 || empty($imageUrl) || $categoryId <= 0) {
      return false;
    }

    $query = "UPDATE productos SET Nombre = :name, Descripcion = :description, Precio = :price, Stock = :stock, Imagen = :imageUrl, CategoriaId = :categoryId WHERE ProductoId = :productId";

    $dbQuery = $this->connection->prepare($query);
    $dbQuery->bindParam(':name', $name, PDO::PARAM_STR);
    $dbQuery->bindParam(':description', $description, PDO::PARAM_STR);
    $dbQuery->bindParam(':price', $price);
    $dbQuery->bindParam(':stock', $stock, PDO::PARAM_INT);
    $dbQuery->bindParam(':imageUrl', $imageUrl, PDO::PARAM_STR);
    $dbQuery->bindParam(':categoryId', $categoryId, PDO::PARAM_INT);
    $dbQuery->bindParam(':productId', $id, PDO::PARAM_INT);
    return $dbQuery->execute();
  }

  public function delete(int $id): bool
  {
    $query = "DELETE FROM productos WHERE ProductoId = :productId";
    $dbQuery = $this->connection->prepare($query);
    $dbQuery->bindParam(':productId', $id, PDO::PARAM_INT);
    return $dbQuery->execute();
  }
}
