<?php


require_once __DIR__ . '/../vendor/autoload.php';

use Controllers\CatalogController;
use Controllers\ProductController;
use Controllers\Admin\DashboardController;

return [
  "/products" => [CatalogController::class, 'showCatalog'],
  "/products/detail" => [ProductController::class, 'showProductById'],
  "/admin/dashboard" => [DashboardController::class, 'showDashboard'],
  "/admin/dashboard/create" => [DashboardController::class, 'showCreateProduct'],
  "/admin/dashboard/create/product" => [DashboardController::class, 'createProduct'],
  "/admin/dashboard/edit" => [DashboardController::class, 'showEditProduct'],
  "/admin/dashboard/update/product" => [DashboardController::class, 'editProduct'],
  "/admin/dashboard/product/delete" => [DashboardController::class, 'deleteProduct']

];
