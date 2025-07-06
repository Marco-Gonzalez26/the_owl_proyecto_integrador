<?php
require_once __DIR__ . '/../../../services/CloudinaryService.php';
$deps = require __DIR__ . '/../../config/bootstrap.php';


$productController = $deps['productController'];

$cloudinaryService = $deps['cloudinary'];

$productId = $_GET['productId'] ?? null;

if (!$productId) {
  echo "<script>alert('ID de producto no proporcionado'); 
    window.location.href = '/apps/theowl/admin/dashboard?error=true';
  </script>";
  exit;
}

$product = $productController->showProductById($productId);

if (!$product) {
  echo "<script>alert('Producto no encontrado'); 
    window.location.href = '/apps/theowl/admin/dashboard?error=true';
  </script>";
}

$productImageUrl = $product['Imagen'];

if (isset($_POST['nombre']) && isset($_POST['descripcion']) && isset($_POST['precio']) && isset($_POST['stock']) && isset($_POST['categoria'])) {
  // Recieve form data
  $name = $_POST['nombre'];
  $description = $_POST['descripcion'];
  $price = $_POST['precio'];
  $stock = $_POST['stock'];
  $categoryId = $_POST['categoria'] ?? null;

  if ($_FILES['imagen']['tmp_name']) {
    // Validate form data
    $image = $_FILES['imagen'];
    $imageUrl = $cloudinaryService->uploadImage($image['tmp_name']) ?? $productImageUrl;
  } else {
    // If no new image is uploaded, keep the old image URL
    $imageUrl = $productImageUrl;
  }


  $product = $productController->updateProduct($productId, $name, $description, $price, $stock, $imageUrl, $categoryId);
  if ($product) {
    echo "<script>alert('Producto actualizado con éxito'); 
      window.location.href = '/apps/theowl/admin/dashboard?success=true';
    </script>";
  } else {
    echo "<script>alert('Error al actualizar el producto');
      </script>";
  }
} else {
  echo "<script>alert('Por favor, complete todos los campos');</script>";
}
