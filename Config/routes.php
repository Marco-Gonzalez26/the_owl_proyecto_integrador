<?php


require_once __DIR__ . '/../vendor/autoload.php';

use Controllers\Admin\AuthenticationController;
use Controllers\Admin\CategoriesAdminController;
use Controllers\Admin\DashboardController;
use Controllers\Admin\ProductAdminController;
use Controllers\Admin\ProviderAdminController;
use Controllers\Admin\BrandAdminController;
use Controllers\Admin\BrandSizeAdminController;

use Controllers\CatalogController;
use Controllers\ProductController;
use Controllers\CartController;
use Controllers\HomeController;

return [
  "/" => [HomeController::class, 'index'],
  "/cart" => [CartController::class, 'getCart'],
  "/cart/save" => [CartController::class, 'saveCart'],
  "/cart/add" => [CartController::class, 'addProduct'],
  "/cart/delete" => [CartController::class, 'deleteProduct'],
  "/products" => [CatalogController::class, 'showCatalog'],
  "/products/detail" => [ProductController::class, 'showProductById'],
  "/admin/userLogin" => [AuthenticationController::class, 'userLogin'],
  "/admin" => [AuthenticationController::class, 'showLoginPage'],
  "/admin/logout" => [AuthenticationController::class, 'logout'],
  "/admin/products" => [ProductAdminController::class, 'showAdminProducts'],
  "/admin/categories" => [CategoriesAdminController::class, 'showAdminCategories'],
  "/admin/brands" => [BrandAdminController::class, 'showBrands'],
  "/admin/providers" => [ProviderAdminController::class, 'showProviders'],
  "/admin/dashboard" => [DashboardController::class, 'showDashboard'],
  "/admin/dashboard/create" => [DashboardController::class, 'showCreate'],
  "/admin/dashboard/edit" => [DashboardController::class, 'showEdit'],
  "/admin/dashboard/create/category" => [DashboardController::class, 'createCategory'],
  "/admin/dashboard/update/category" => [DashboardController::class, 'editCategory'],
  "/admin/dashboard/category/delete" => [DashboardController::class, 'deleteCategory'],
  "/admin/dashboard/create/product" => [DashboardController::class, 'createProduct'],
  "/admin/dashboard/update/product" => [DashboardController::class, 'editProduct'],
  "/admin/dashboard/product/delete" => [DashboardController::class, 'deleteProduct'],
  "/admin/dashboard/provider/create" => [ProviderAdminController::class, 'createProvider'],
  "/admin/dashboard/provider/update" => [ProviderAdminController::class, 'editProvider'],
  "/admin/dashboard/provider/delete" => [ProviderAdminController::class, 'deleteProvider'],
  "/admin/dashboard/brand/create" => [BrandSizeAdminController::class, 'createBrandWithSizes'],
  "/admin/dashboard/brand/update" => [BrandAdminController::class, 'editBrand'],
  "/admin/dashboard/brand/delete" => [BrandAdminController::class, 'deleteBrand']

];
