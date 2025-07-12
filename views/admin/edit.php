<?php require_once __DIR__ . '/../../layouts/admin_header.php';

?>

<div class="container-fluid">
  <div class="row">
    <?php require_once __DIR__ . '/../../layouts/admin_sidebar.php'; ?>

    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
      <h2>Editar Producto</h2>

      <?php if (isset($_GET['success'])): ?>
        <div class="alert alert-success">Producto <?= htmlspecialchars($_GET['success']) ?> correctamente</div>
      <?php endif; ?>

      <form action="/apps/theowl/public/admin/dashboard/update/product?productId=<?= $product['ProductoId'] ?>" method="POST" enctype="multipart/form-data">
        <div class="mb-3">
          <label for="nombre" class="form-label">Nombre del Producto</label>
          <input type="text" class="form-control" id="nombre" name="nombre" value="<?= htmlspecialchars($product['Nombre']) ?>">
        </div>
        <div class="mb-3">
          <label for="descripcion" class="form-label">Descripción del Producto</label>
          <textarea class="form-control" id="descripcion" name="descripcion"><?= htmlspecialchars($product['Descripcion']) ?></textarea>
        </div>

        <div class="mb-3">
          <label for="precio" class="form-label">Precio</label>
          <input type="number" min="0" class="form-control" id="precio" name="precio" step="0.01" value="<?= htmlspecialchars($product['Precio']) ?>">
        </div>
        <div class="mb-3">
          <label for="stock" class="form-label">Stock</label>
          <input type="number" min="0" class="form-control" id="stock" name="stock" value="<?= htmlspecialchars($product['Stock']) ?>">
        </div>
        <div class="mb-3">
          <label for="categoria" class="form-label">Categoría</label>
          <select class="form-select" id="categoria" name="categoria">
            <option value="">Seleccione una categoría</option>
            <?php foreach ($categories as $category): ?>
              <option value="<?= $category['CategoriaId'] ?>"
                <?= $product['CategoriaId'] == $category['CategoriaId'] ? 'selected' : '' ?>>
                <?= htmlspecialchars($category['Nombre']) ?>
              </option>
            <?php endforeach; ?>
          </select>
        </div>

        <div class="mb-3">
          <label for="imagen" class="form-label">Imagen del Producto</label>
          <input type="file" class="form-control" id="imagen" name="imagen" value="<?= htmlspecialchars($product['Imagen']) ?>">
        </div>
        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
      </form>
    </main>

  </div>
</div>

<?php require_once __DIR__ . '/../../layouts/admin_footer.php'; ?>
<style>
  .container-fluid {
    padding: 20px;
  }

  .form-label {
    font-weight: bold;
  }

  .img-thumbnail {
    max-width: 100%;
    height: auto;
  }
</style>