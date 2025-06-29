<link rel="stylesheet" href="/apps/theowl/assets/css/styles.css">
<link rel="stylesheet" href="/apps/theowl/assets/css/products.css">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>



<?php
define('BASE_PATH', __DIR__);
$request = $_SERVER['REQUEST_URI'];
$basePath = '/apps/theowl';

$pathName = str_replace($basePath, '', parse_url($request, PHP_URL_PATH));


$viewDirectory = '/views/';

switch ($pathName) {
  case '':
  case '/':
    require __DIR__ . $viewDirectory . 'home.php';
    break;
  case '/products':

    require __DIR__ . $viewDirectory . 'products/list.php';
    break;
  case '/products/detail':

    require __DIR__ . $viewDirectory . 'products/detail.php';
    break;
  case '/admin/dashboard':
    require __DIR__ . $viewDirectory . 'admin/dashboard.php';
    break;
  case '/admin/dashboard/create':
    require __DIR__ . $viewDirectory . 'admin/create.php';
    break;

  case '/admin/dashboard/edit':
    require __DIR__ . $viewDirectory . 'admin/edit.php';
    break;
  case '/admin/dashboard/create/products':
    require __DIR__ . $viewDirectory . 'admin/php/create_product.php';
    break;
  case '/admin/dashboard/update/product':
    require __DIR__ . $viewDirectory . 'admin/php/edit_product.php';
    break;
  case '/admin/dashboard/product/delete':
    require __DIR__ . $viewDirectory . 'admin/php/delete_product.php';
    break;
  default:
    http_response_code(404);
    require __DIR__ . $viewDirectory . 'error/404.php';
    break;
}
