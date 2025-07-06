<?php
require_once __DIR__ . '/../handlers/ViewsErrorHandler.php';
require_once __DIR__ . '/../repositories/ProductRepository.php';
require_once __DIR__ . '/../config/db_connection.php';

class ProductControllerFactory
{
  public static function create(): ProductController
  {
    $connection = DbConnection::getInstance()->getConnection();
    return new ProductController(
      new ProductRepository($connection),
      new ViewsErrorHandler()
    );
  }
}
