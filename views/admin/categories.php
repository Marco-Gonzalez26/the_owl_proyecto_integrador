<?php
require_once __DIR__ . '/../../layouts/admin_header.php';

?>
<div class="container h-100">
  <div class="row h-100 position-relative">
    <?php require_once __DIR__ . '/../../layouts/admin_sidebar.php'; ?>

    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
      <div class="d-flex gap-2 flex-row w-100 justify-content-between">

        <h3>Categorias</h3>
        <a href="/apps/theowl/public/admin/dashboard/create?identifier=categories" class="btn btn-primary mb-3 fw-semibold">Nueva Categoria</a>
      </div>


      <div class="table-responsive">
        <table class="table table-striped table-sm">
          <thead>
            <tr>
              <th>ID</th>
              <th>Nombre</th>
              <th>Acciones</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($categories as $category): ?>
              <tr>
                <td><?= $category['CategoriaId'] ?></td>
                <td><?= htmlspecialchars($category['Nombre']) ?></td>
                <td>
                  <a href="/apps/theowl/public/admin/dashboard/edit?identifier=categories&id=<?= $category['CategoriaId'] ?>" class="btn btn-sm btn-light">Editar</a>
                  <form action="/apps/theowl/public/admin/dashboard/category/delete?identifier=categories&categoryId=<?= $category['CategoriaId'] ?>" method="POST" class="d-inline">
                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Eliminar esta categoria?')">Eliminar</button>
                  </form>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </main>
  </div>
</div>

<?php require_once __DIR__ . '/../../layouts/admin_footer.php'; ?>