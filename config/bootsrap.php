<?php
require_once __DIR__ . '/db_connection.php';
require_once __DIR__ . '/../services/ProductControllerFactory.php';
require_once __DIR__ . '/../services/CloudinaryService.php';

$cloudinaryService = new CloudinaryService();

$productController = ProductControllerFactory::create();

return [
  'db' => $connection,
  'productController' => $productController,
  'cloudinary' => $cloudinaryService
];
