<?php

require_once BASE_PATH . '/config/bootstrap.php';
require_once BASE_PATH . '/layouts/header.php';

$deps = require BASE_PATH . '/config/bootstrap.php';
// Verificar si se ha pasado un ID de producto
$productId = isset($_GET['id']) ? intval($_GET['id']) : 1; // Default to 1 if not set

$productController = $deps['productController'];
$product = $productController->showProductById($productId);

?>

<div class="container my-5">
  <h2 class="mb-4">Detalles del Producto</h2>
  <div class="row">
    <!-- Imágenes del producto -->
    <div class="col-md-6">
      <div class="main-image mb-3">
        <img src="<?= htmlspecialchars($product['Imagen']) ?>"
          class="img-fluid rounded"
          alt="<?= htmlspecialchars($product['Nombre']) ?>">
      </div>
    </div>

    <!-- Información del producto -->
    <div class="col-md-6">
      <h1><?= htmlspecialchars($product['Nombre']) ?></h1>

      <?php if (!empty($product['NombreCategoria'])): ?>
        <span class="badge bg-secondary mb-2"><?= htmlspecialchars($product['NombreCategoria']) ?></span>
      <?php endif; ?>

      <div class="d-flex align-items-center my-3 mx-2">
        <span class="display-5 text-primary me-3">$<?= number_format($product['Precio'], 2) ?></span>

        <?php if ($product['Stock'] > 0): ?>
          <span class="text-success mx-2">
            <i class="fas fa-check-circle"></i> Disponible
          </span>
        <?php else: ?>
          <span class="text-danger">
            <i class="fas fa-times-circle"></i> Agotado
          </span>
        <?php endif; ?>
      </div>

      <hr>

      <h4>Descripción</h4>
      <p class="lead"><?= nl2br(htmlspecialchars($product['Descripcion'])) ?></p>
    </div>
  </div>
</div>

<style>
  <?php
  require_once BASE_PATH . '/layouts/footer.php';
  ?>