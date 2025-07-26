
<?php
require_once __DIR__ . '/../vendor/autoload.php';
session_start();
define('BASE_PATH', __DIR__);



$routes = require_once __DIR__ . '/../config/routes.php';
$container = require_once __DIR__ . '/../config/container.php';


$request = $_SERVER['REQUEST_URI'];
$basePath = '/apps/theowl/public';
$url = parse_url($request, PHP_URL_PATH);
$pathName = str_replace($basePath, '', $url);

if (isset($routes[$pathName])) {
  [$controllerClass, $method] = $routes[$pathName];
  $controller = $container[$controllerClass];

  if (isset($_GET['id'])) {
    $controller->$method($_GET['id']);
  } else {
    $controller->$method();
  }
} else {
  http_response_code(404);
  echo "<h1>Pagina no encontrada</h1>";
}
