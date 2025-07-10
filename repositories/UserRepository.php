<?php

namespace Repositories;

use Exception;
use Models\User;
use Interfaces\UserRepositoryInterface;
use PDO;

class UserRepository implements UserRepositoryInterface
{

  private $connection;
  public function __construct(PDO $connection)
  {
    $this->connection = $connection;
  }
  public function getAll(): array
  {
    $query = "SELECT u.id, u.nombre_usuario, u.contrasena, r.id, r.Nombre as NombreRole 
              FROM usuarios u
              JOIN roles r ON u.rol = r.id;";
    $users = $this->connection->query($query);
    return $users->fetchAll(PDO::FETCH_ASSOC);
  }
  public function getById(int $id): array
  {
    $query = "SELECT u.id, u.nombre_usuario, u.contrasena, r.id, r.Nombre as NombreRole 
              FROM usuarios u
              JOIN roles r ON u.rol = r.id WHERE u.id = :userId";

    $dbQuery = $this->connection->prepare($query);
    $dbQuery->bindParam(':userId', $id, PDO::PARAM_INT);
    $user = $dbQuery->fetch(PDO::FETCH_ASSOC);
    return $user  ?: [];
  }

  public function getByUsername(string $username): ?User
  {
    $query = "SELECT u.id, u.nombre_usuario, u.contrasena, r.id, r.Nombre as NombreRole 
    WHERE nombre_usuarios = :username;";

    $dbQuery = $this->connection->prepare($query);

    $dbQuery->bindParam(":username", $username, PDO::PARAM_STR);

    $user = $dbQuery->fetch();

    if ($user) {
      return new User(
        (int) $user["id"],
        $user["nombre_usuario"],
        $user["contrasena"],
        $user["role"]
      );
    } else {
      return null;
    }
  }

  public function create(User $data): bool
  {
    $username = $data->username;
    $password = $data->password;
    $roleId = $data->role->roleId;

    if (empty($username) || empty($password) || empty($roleId)) {
      throw new Exception("Todos los campos son obligatorios y deben ser válidos.");
    }
    $query = "INSERT INTO usuarios (nombre_usuario, contrasena, rol)
              VALUES (:username, :password, :roleId)";
    $dbQuery = $this->connection->prepare($query);
    $dbQuery->bindParam(':username', $username, PDO::PARAM_STR);
    $dbQuery->bindParam(':password', $password, PDO::PARAM_STR);
    $dbQuery->bindParam(':roleId', $roleId, PDO::PARAM_INT);
    return $dbQuery->execute();
  }


  public function update(int $id, User $data): bool
  {
    $username = $data->username;
    $password = $data->password;
    $roleId = $data->role->roleId;

    if (empty($username) || empty($password) || empty($roleId)) {
      throw new Exception("Todos los campos son obligatorios y deben ser válidos.");
    }
    $query = "UPDATE usuarios SET nombre_usuario = :username, contrasena = :password WHERE id = :userId";
    $dbQuery = $this->connection->prepare($query);
    $dbQuery->bindParam(':username', $username, PDO::PARAM_STR);
    $dbQuery->bindParam(':password', $password, PDO::PARAM_STR);
    $dbQuery->bindParam(':roleId', $roleId, PDO::PARAM_INT);
    $dbQuery->bindParam(':userId', $id, PDO::PARAM_INT);
    return $dbQuery->execute();
  }
  public function delete(int $id): bool
  {
    $query = "DELETE FROM usuarios WHERE id = :userId";
    $dbQuery = $this->connection->prepare($query);
    $dbQuery->bindParam(':userId', $id, PDO::PARAM_INT);
    return $dbQuery->execute();
  }
}
