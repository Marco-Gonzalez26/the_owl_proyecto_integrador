<?php


require_once __DIR__ . '/../vendor/autoload.php';

use Controllers\CatalogController;
use Controllers\ProductController;

return [
  "/products" => [CatalogController::class, 'showCatalog'],
  "/products/detail" => [ProductController::class, 'showProductById']
];
