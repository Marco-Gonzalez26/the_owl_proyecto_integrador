<link rel="stylesheet" href="/apps/theowl/assets/css/styles.css">
<link rel="stylesheet" href="/apps/theowl/assets/css/products.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>

<?php
require_once __DIR__ . '/../vendor/autoload.php';
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
// $viewDirectory = '/views/';

// switch ($pathName) {
//   case '':
//   case '/':
//     require __DIR__ . $viewDirectory . 'home.php';
//     break;
//   case '/products':

//     require __DIR__ . $viewDirectory . 'products/list.php';
//     break;
//   case '/products/detail':

//     require __DIR__ . $viewDirectory . 'products/detail.php';
//     break;
//   case '/admin/dashboard':
//     require __DIR__ . $viewDirectory . 'admin/dashboard.php';
//     break;
//   case '/admin/dashboard/create':
//     require __DIR__ . $viewDirectory . 'admin/create.php';
//     break;

//   case '/admin/dashboard/edit':
//     require __DIR__ . $viewDirectory . 'admin/edit.php';
//     break;
//   case '/admin/dashboard/create/products':
//     require __DIR__ . $viewDirectory . 'admin/php/create_product.php';
//     break;
//   case '/admin/dashboard/update/product':
//     require __DIR__ . $viewDirectory . 'admin/php/edit_product.php';
//     break;
//   case '/admin/dashboard/product/delete':
//     require __DIR__ . $viewDirectory . 'admin/php/delete_product.php';
//     break;
//   default:
//     http_response_code(404);
//     require __DIR__ . $viewDirectory . 'error/404.php';
//     break;
// }
