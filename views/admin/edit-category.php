<?php
ob_start();
?>
<div class="container h-100">
  <div class="row">
    <?php require_once __DIR__ . '/../../layouts/admin_sidebar.php'; ?>

    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
      <h2>Editar Categoria</h2>

      <?php if (isset($_GET['success'])): ?>
        <div class="alert alert-success">Categoria <?= htmlspecialchars($_GET['success']) ?> correctamente</div>
      <?php endif; ?>

      <form action="/apps/theowl/public/admin/dashboard/update/category?categoryId=<?= $category['CategoriaId'] ?>" method="POST" enctype="multipart/form-data">
        <div class="mb-3">
          <label for="nombre" class="form-label">Nombre de la categoria</label>
          <input type="text" class="form-control" id="nombre" name="nombre" value="<?= htmlspecialchars($category['Nombre']) ?>">
        </div>

        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
      </form>
    </main>

  </div>
</div>
<?php
$content = ob_get_clean();
$layoutData = ['title' => 'Editar Categoria'];
require __DIR__ . '/../../Layouts/layout.php';
?>
<style>
  .form-label {
    font-weight: bold;
  }
</style>