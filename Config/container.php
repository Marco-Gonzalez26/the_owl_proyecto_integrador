<?php

namespace Config;

require_once __DIR__ . '/../vendor/autoload.php';

use Interfaces\ProductRepositoryInterface;
use Interfaces\ProductServiceInterface;
use Interfaces\CategoryRepositoryInterface;
use Interfaces\CategoryServiceInterface;

use Repositories\ProductRepository;
use Repositories\CategoryRepository;
use Services\ProductService;
use Services\CategoryService;
use Controllers\ProductController;
use Controllers\CatalogController;

use Config\DatabaseConnection;


$connection = DatabaseConnection::getInstance()->getConnection();

return [
  ProductRepositoryInterface::class => new ProductRepository($connection),
  ProductServiceInterface::class => new ProductService(new ProductRepository($connection)),
  ProductController::class => new ProductController(new ProductService(new ProductRepository($connection))),
  CatalogController::class => new CatalogController(new CategoryService(new CategoryRepository($connection)), new ProductService(new ProductRepository($connection)))
];
