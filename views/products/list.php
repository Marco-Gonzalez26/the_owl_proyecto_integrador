<?php
require_once __DIR__ . '/../../Layouts/header.php';

?>

<section class="container my-5">
  <h2 class="mb-4 ">Nuestros Productos</h2>


  <div class="row mb-4">
    <div class="col-md-3 categories-container">
      <label for="category" class="form-label">Categoría:</label>
      <select class="form-select" id="category" onchange="applyFilters()">
        <option value="">Todas las categorías</option>
        <?php foreach ($categories as $category): ?>
          <option value="<?= $category['CategoriaId'] ?>"
            <?= ($_GET['category'] ?? '') == $category['CategoriaId'] ? 'selected' : '' ?>>
            <?= htmlspecialchars($category['Nombre']) ?>
          </option>
        <?php endforeach; ?>
      </select>
    </div>
  </div>

  <!-- Listado de productos -->
  <div class="row">
    <?php if (empty($products)): ?>
      <div class="col-12 text-center py-5">
        <h4>No se encontraron productos</h4>
        <p>Intenta con otros criterios de filtrado</p>
      </div>
    <?php else: ?>
      <?php foreach ($products as $product): ?>
        <div class="col-md-4 mb-4 w-100">
          <div class="ard h-1c00 product-card">
            <img src="<?= htmlspecialchars($product['Imagen']) ?>"
              class="card-img-top img-fluid"
              alt="<?= htmlspecialchars($product['Nombre']) ?>">
            <div class="card-body">
              <h5 class="card-title"><?= htmlspecialchars($product['Nombre']) ?></h5>
            </div>
            <div class="card-footer bg-white">
              <a href="/apps/theowl/public/products/detail?id=<?= $product['ProductoId'] ?>" class="btn btn-primary w-100">Ver Detalles</a>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    <?php endif; ?>
  </div>
</section>
<?php
require_once __DIR__ . '/../../Layouts/footer.php';
?>
<style>
  .categories-container {
    display: flex;
    align-items: center;
    gap: 10px;
  }

  label {
    font-weight: 500;
  }

  select {
    padding: 5px 10px;
    border-radius: 5px;
  }

  .product-card {
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    flex-direction: column;
    justify-content: space-between;
  }

  .product-card img {
    width: 50%;
    object-fit: cover;
  }

  .card_body {
    flex-grow: 1;
    justify-content: center;
    align-items: center;
  }
</style>