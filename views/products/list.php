<?php
ob_start();
?>
<section class="container my-5">
  <h2 class="mb-4 text-body">Nuestros Productos</h2>


  <div class="row mb-4">
    <div class="col-md-3 categories-container align-items-center g-1 flex-lg-row">
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
  <div class="row g-4">
    <?php if (empty($products)): ?>
      <div class="col-12 text-center py-5">
        <h4>No se encontraron productos</h4>
        <p>Intenta con otros criterios de filtrado</p>
      </div>
    <?php else: ?>
      <div class="col-lg-9 mt-4">
        <div class="row g-4">
          <?php foreach ($products as $product): ?>
            <div class="col-md-4 ">
              <div class="product-card shadow-sm">
                <div class="position-relative">
                  <img src="<?= htmlspecialchars($product['Imagen']) ?>" class="product-image w-100 object-fit-scale" alt="<?= htmlspecialchars($product['Nombre']) ?>">
                </div>
                <div class="p-3">
                  <span class="category-badge mb-2 d-inline-block"><?= htmlspecialchars($product['NombreCategoria']) ?></span>
                  <h6 class="mb-1"><?= htmlspecialchars($product['Nombre']) ?></h6>
                  <div class="d-flex justify-content-between align-items-center">
                    <span class="price"><?= htmlspecialchars($product['Precio']) ?>$</span>

                    <a class="btn btn-primary" href="/apps/theowl/public/products/detail?id=<?= $product['ProductoId'] ?>">
                      Ver detalles
                    </a>

                  </div>
                </div>
              </div>
            </div>
          <?php endforeach; ?>
        <?php endif; ?>
        </div>
      </div>
  </div>
</section>
<style>
  .price {
    color: #2563eb;
    font-weight: 600;
  }

  .category-badge {
    background-color: #2563eb;
    color: #fff;
    padding: .25em .50em;
    font-size: 12px;
    border-radius: 12px;
  }

  .product-card {
    background: white;
    border-radius: 12px;
    height: 100%;
  }


  .product-image {
    height: 200px;
    object-fit: scale-down;
    border-radius: 12px 12px 0 0;
    z-index: 0;
  }

  label {
    font-weight: 500;
  }

  .card {
    width: 12rem;
  }

  select {
    padding: 5px 10px;
    border-radius: 5px;
  }
</style>
<?php
$content = ob_get_clean();
$layoutData = ['title' => 'Productos'];
require __DIR__ . '/../../layouts/layout.php';
?>