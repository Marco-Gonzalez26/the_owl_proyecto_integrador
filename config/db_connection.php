<?php



class DbConnection
{
  // Variables
  private $host = 'localhost';
  private $dbname = 'the_owl_proyecto_integrador';
  private $user = 'root';
  private $password = '';
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
      self::$instance = new DbConnection();
    }
    return self::$instance;
  }
}
