<?php

$deps = require __DIR__ . '/../../config/bootstrap.php';


$productController = $deps['productController'];
$productId = $_GET['productId'] ?? null;

if (!$productId) {
  echo "<script>alert('ID de producto no proporcionado'); 
    window.location.href = '/apps/theowl/admin/dashboard?error=true';
  </script>";
  exit;
}

if ($productController->deleteProduct($productId)) {
  echo "<script>alert('Producto eliminado con éxito'); 
    window.location.href = '/apps/theowl/admin/dashboard?success=true';
  </script>";
}
