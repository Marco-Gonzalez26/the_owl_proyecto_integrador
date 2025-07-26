<?php require_once __DIR__ . '/../../layouts/admin_header.php';


?>

<div class="container-fluid h-full">
  <div class="row position-relative">
    <?php require_once __DIR__ . '/../../layouts/admin_sidebar.php'; ?>

    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
      <h3>Crear Producto</h3>

      <?php if (isset($_GET['success'])): ?>
        <div class="alert alert-success">Registro <?= htmlspecialchars($_GET['success']) ?> correctamente</div>
      <?php endif; ?>

      <form action="/apps/theowl/public/admin/dashboard/create/product" method="POST" enctype="multipart/form-data">
        <div class="mb-3">
          <label for="name" class="form-label">Nombre</label>
          <input type="text" class="form-control" id="name" name="nombre" required>
        </div>
        <div class="mb-3">
          <label for="description" class="form-label">Descripción</label>
          <textarea class="form-control" id="description" name="descripcion" rows="4" required></textarea>
        </div>
        <div class="mb-3">
          <label for="precio" class="form-label">Precio</label>
          <input type="number" class="form-control" id="precio" name="precio" step="0.01" required>
        </div>
        <div class="form-flex mb-3 ">
          <div class="w-50">
            <label for="stock" class="form-label ">Stock</label>
            <input type="number" class="form-control w-100" id="stock" name="stock" required>
          </div>
          <div class="w-50">
            <label for="categoria" class="form-label mt-2">Categoría</label>
            <select class="form-select mt-2 w-100" id="categoria" name="categoria" required>
              <option value="">Seleccionar categoría</option>
              <?php foreach ($categories as $category): ?>
                <option value="<?= $category['CategoriaId'] ?>"><?= htmlspecialchars($category['Nombre']) ?></option>
              <?php endforeach; ?>
            </select>
          </div>
        </div>
        <div class="mb-3">
          <label for="imagen" class="form-label">Imagen</label>
          <input type="file" class="form-control" id="imagen" name="imagen" accept="image/*" required>
        </div>
        <button type="submit" class="btn btn-primary">Crear</button>
      </form>

    </main>
  </div>
</div>

<?php require_once __DIR__ . '/../../layouts/admin_footer.php'; ?>
<style>
  .form-label {
    font-weight: bold;
  }

  .form-control {
    border-radius: 0.25rem;
  }

  .btn-primary {
    background-color: #007bff;
    border-color: #007bff;
  }

  .btn-primary:hover {
    background-color: #0056b3;
    border-color: #0056b3;
  }

  .container-fluid {
    padding: 2rem;
  }

  .form-flex {
    display: flex;
    width: 100%;
    justify-content: center;
    align-items: center;
    gap: 1rem;
  }
</style>