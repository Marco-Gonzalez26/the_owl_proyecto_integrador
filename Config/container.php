<?php

namespace Config;

require_once __DIR__ . '/../vendor/autoload.php';

use Interfaces\ProductRepositoryInterface;
use Interfaces\ProductServiceInterface;
use Interfaces\CategoryRepositoryInterface;
use Interfaces\CategoryServiceInterface;
use Interfaces\CloudinaryServiceInterface;

use Repositories\ProductRepository;
use Repositories\CategoryRepository;
use Services\ProductService;
use Services\CategoryService;
use Services\CloudinaryService;
use Controllers\ProductController;
use Controllers\CatalogController;

use Controllers\Admin\DashboardController;
use Config\DatabaseConnection;


$connection = DatabaseConnection::getInstance()->getConnection();

return [
  ProductRepositoryInterface::class => new ProductRepository($connection),
  ProductServiceInterface::class => new ProductService(new ProductRepository($connection)),
  ProductController::class => new ProductController(new ProductService(new ProductRepository($connection))),
  CatalogController::class => new CatalogController(new CategoryService(new CategoryRepository($connection)), new ProductService(new ProductRepository($connection))),
  DashboardController::class => new DashboardController(new CategoryService(new CategoryRepository($connection)), new ProductService(new ProductRepository($connection)), new CloudinaryService()),
];
