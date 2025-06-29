<?php
require_once BASE_PATH . '/config/db_connection.php';
class ProductModel
{
  private $connection;
  public $name;
  public $description;
  public $price;
  public $productId;
  public $categoryId;
  public $stock;
  public $imageUrl;

  public function __construct()
  {
    $dbInstance = DbConnection::getInstance();
    $this->connection = $dbInstance->getConnection();
    $this->name = '';
    $this->description = '';
    $this->price = 0.0;
    $this->productId = 0;
    $this->categoryId = 0;
    $this->stock = 0;
    $this->imageUrl = '';
  }

  public function __destruct()
  {
    $this->connection = null;
  }

  public function getAllProducts()
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
    } else {
      echo "No se encontraron productos.";
    }
    return $products;
  }

  public function getProductById($productId)
  {
    $query = "SELECT p.*, c.Nombre as NombreCategoria
               FROM productos p
               JOIN categorias c ON p.CategoriaId = c.CategoriaId
               WHERE p.ProductoID = :productId";

    $dbQuery = $this->connection->prepare($query);
    $dbQuery->bindParam(':productId', $productId, PDO::PARAM_INT);
    $dbQuery->execute();
    $product = $dbQuery->fetch(PDO::FETCH_ASSOC);
    return $product;
  }

  public function insertProduct($name, $description, $price, $stock, $imageUrl, $categoryId)
  {
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

  public function updateProduct($productId, $name, $description, $price, $stock, $imageUrl, $categoryId)
  {
    $query = "UPDATE productos SET Nombre = :name, Descripcion = :description, Precio = :price, Stock = :stock, Imagen = :imageUrl, CategoriaId = :categoryId WHERE ProductoId = :productId";
    if (empty($name) || empty($description) || $price <= 0 || $stock < 0 || empty($imageUrl) || $categoryId <= 0) {
      return false; 
    }

    $dbQuery = $this->connection->prepare($query);
    $dbQuery->bindParam(':name', $name, PDO::PARAM_STR);
    $dbQuery->bindParam(':description', $description, PDO::PARAM_STR);
    $dbQuery->bindParam(':price', $price);
    $dbQuery->bindParam(':stock', $stock, PDO::PARAM_INT);
    $dbQuery->bindParam(':imageUrl', $imageUrl, PDO::PARAM_STR);
    $dbQuery->bindParam(':categoryId', $categoryId, PDO::PARAM_INT);
    $dbQuery->bindParam(':productId', $productId, PDO::PARAM_INT);
    return $dbQuery->execute();
  }

  public function deleteProduct($productId)
  {
    $query = "DELETE FROM productos WHERE ProductoId = :productId";
    $dbQuery = $this->connection->prepare($query);
    $dbQuery->bindParam(':productId', $productId, PDO::PARAM_INT);
    return $dbQuery->execute();
  }
}
