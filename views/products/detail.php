<?php


ob_start()


?>

<div class="container-fluid my-5">
  <h2 class="mb-4">Detalles del Producto</h2>
  <div class="row">
    <!-- Imágenes del producto -->
    <div class="col-md-6">
      <div class="mb-3">
        <img src="<?= htmlspecialchars($product['Imagen']) ?>"
          class="img-thumbnail rounded w-50"
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
    <!-- Fin de la información del producto -->
    <div>
      <input hidden type="text" id="productId" value="<?= $product['ProductoId'] ?>">
      <input hidden type="text" id="name" value="<?= htmlspecialchars($product['Nombre']) ?>">
      <input hidden type="text" id="price" value="<?= number_format($product['Precio'], 2) ?>">
      <input type="number" id="quantity" class="form-control w-25" value="1" min="1">
      <input hidden type="text" id="imageUrl" value="<?= htmlspecialchars($product['Imagen']) ?>">
      <button class="btn btn-primary" id="add-to-cart-btn">Añadir al carrito</button>
    </div>
  </div>
</div>

<?php
$content = ob_get_clean();
$layoutData = ['title' => 'Producto'];
require __DIR__ . '/../../layouts/layout.php';
?>