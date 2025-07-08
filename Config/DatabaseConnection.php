<?php

namespace Config;

require_once __DIR__ . '/../vendor/autoload.php';

require_once dirname(__DIR__) . '/Config/env.php';

use PDO;
use PDOException;

class DatabaseConnection
{
  // Variables
  private $host = DB_HOST;
  private $dbname = DB_NAME;
  private $user = DB_USER;
  private $password = DB_PASS;
  private $connection;
  private static $instance = null;
  // Constructor
  public function __construct()
  {
    try {
      $this->connection = new PDO(
        "mysql:host={$this->host};dbname={$this->dbname};charset=utf8",
        $this->user,
        $this->password
      );

      // Opciones recomendadas
      $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $this->connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
      $this->connection->setAttribute(PDO::ATTR_PERSISTENT, false);
    } catch (PDOException $e) {
      die("Error de conexión: " . $e->getMessage());
    }
  }

  // Método para obtener la conexión
  public function getConnection(): PDO
  {
    return $this->connection;
  }

  public static function getInstance()
  {
    if (self::$instance === null) {
      self::$instance = new DatabaseConnection();
    }
    return self::$instance;
  }
}
