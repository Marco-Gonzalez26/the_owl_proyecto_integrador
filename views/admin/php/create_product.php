<?php
$deps = require __DIR__ . '/../../config/bootstrap.php';


$productController = $deps['productController'];



if (isset($_POST['nombre']) && isset($_POST['descripcion']) && isset($_POST['precio']) && isset($_POST['stock']) && isset($_FILES['imagen']) && isset($_POST['categoria'])) {
  // Recieve form data
  $name = $_POST['nombre'];
  $description = $_POST['descripcion'];
  $price = $_POST['precio'];
  $stock = $_POST['stock'];
  $image = $_FILES['imagen'];
  $categoryId = $_POST['categoria'] ?? null;
  // Validate form data
  $imageUrl = $cloudinaryService->uploadImage($image['tmp_name']);



  $product = $productController->createProduct($name, $description, $price, $stock, $imageUrl, $categoryId);
  if ($product) {
    echo "<script>alert('Producto creado con éxito'); 
      window.location.href = '/apps/theowl/admin/dashboard?success=true';
    </script>";
  } else {
    echo "<script>alert('Error al crear el producto');
      </script>";
  }
} else {
  echo "<script>alert('Por favor, complete todos los campos');</script>";
}
