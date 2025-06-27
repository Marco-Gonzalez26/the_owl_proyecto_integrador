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

  public function getCategories()
  {
    $query = "SELECT Id, Nombre FROM Categorias WHERE Estado = 1 ORDER BY Nombre";
    $categories = $this->connection->query($query);
    return $categories->fetchAll(PDO::FETCH_ASSOC);
  }
}
