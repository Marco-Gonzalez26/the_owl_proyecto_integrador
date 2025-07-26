<?php

namespace Config;

require_once __DIR__ . '/../vendor/autoload.php';

use Controllers\Admin\BrandSizeAdminController;
use Interfaces\ProductRepositoryInterface;
use Interfaces\ProductServiceInterface;
use Interfaces\CartRepositoryInterface;
use Interfaces\CategoryRepositoryInterface;
use Interfaces\CategoryServiceInterface;
use Interfaces\CloudinaryServiceInterface;
use Interfaces\AuthenticationServicieInterface;
use Interfaces\BrandRepositoryInterface;
use Interfaces\BrandServiceInterface;

use Repositories\ProductRepository;
use Repositories\CategoryRepository;
use Repositories\UserRepository;
use Repositories\CartRepository;
use Repositories\ProviderRepository;
use Repositories\BrandRepository;
use Repositories\SizeRepository;
use Repositories\BrandSizeRepository;

use Services\BrandService;
use Services\ProductService;
use Services\CategoryService;
use Services\CloudinaryService;
use Services\AuthenticationService;
use Services\CartService;
use Services\ProviderService;
use Services\SizeService;
use Services\BrandSizeService;


use Controllers\ProductController;
use Controllers\CatalogController;
use Controllers\CartController;

use Controllers\Admin\ProviderAdminController;
use Controllers\Admin\DashboardController;
use Controllers\Admin\AuthenticationController;
use Controllers\Admin\CategoriesAdminController;
use Controllers\Admin\ProductAdminController;
use Controllers\Admin\BrandAdminController;

use Config\DatabaseConnection;
use Controllers\HomeController;

$connection = DatabaseConnection::getInstance()->getConnection();

return [
  ProductRepositoryInterface::class => new ProductRepository($connection),
  ProductServiceInterface::class => new ProductService(new ProductRepository($connection)),
  ProductController::class => new ProductController(new ProductService(new ProductRepository($connection))),
  CatalogController::class => new CatalogController(new CategoryService(new CategoryRepository($connection)), new ProductService(new ProductRepository($connection))),
  DashboardController::class => new DashboardController(new CategoryService(new CategoryRepository($connection)), new ProductService(new ProductRepository($connection)), new CloudinaryService(new CloudinaryConfig()), new AuthenticationService(new UserRepository($connection)), new ProviderService(new ProviderRepository($connection)), new BrandService(new BrandRepository($connection)), new BrandSizeService(new BrandRepository($connection), new BrandSizeRepository($connection), new SizeRepository($connection))),
  ProductAdminController::class => new ProductAdminController(new CategoryService(new CategoryRepository($connection)), new ProductService(new ProductRepository($connection)), new AuthenticationService(new UserRepository($connection)), new CloudinaryService(new CloudinaryConfig())),
  CategoriesAdminController::class => new CategoriesAdminController(new CategoryService(new CategoryRepository($connection))),
  AuthenticationController::class => new AuthenticationController(new AuthenticationService(new UserRepository($connection))),
  CartController::class => new CartController(new CartService(new CartRepository())),
  ProviderAdminController::class => new ProviderAdminController(new ProviderService(new ProviderRepository($connection))),
  BrandAdminController::class => new BrandAdminController(new BrandService(new BrandRepository($connection)), new SizeService(new SizeRepository($connection))),
  BrandSizeAdminController::class => new BrandSizeAdminController(new BrandSizeService(new BrandRepository($connection), new BrandSizeRepository($connection), new SizeRepository($connection))),
  HomeController::class => new HomeController(),


];
