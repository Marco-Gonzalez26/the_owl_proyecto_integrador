<?php

namespace Controllers\Admin;

use Services\AuthenticationService;

class AuthenticationController
{
  private $service;

  public function __construct(AuthenticationService $service)
  {
    $this->service = $service;
  }

  public function showLoginPage()
  {
    require_once __DIR__ . '/../../views/admin/login.php';
  }

  public function userLogin()
  {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
      http_response_code(405);
      die("Esta ruta solo acepta POST");
    }

    $username = $_POST['nombre_usuario'] ?? null;
    $password = $_POST['contrasena'] ?? null;


    if (!$username || !$password) {
      header("Location: /apps/theowl/public/admin");
      exit;
    }

    $isLogged = $this->service->login($username, $password);
    if ($isLogged) {
      $_SESSION['usuario'] = $username;
      header("Location: /apps/theowl/public/admin/dashboard");
    } else {
      $_SESSION['login_error'] = "Credenciales incorrectas";
    }
  }

  public function logout()
  {
    $this->service->logout();
    header("Location: /apps/theowl/public/admin");
  }
}
