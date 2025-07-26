<?php
require_once __DIR__ . '/../../layouts/admin_header.php';

?>
<div class="container h-100">
  <div class="row h-100 position-relative">
    <?php require_once __DIR__ . '/../../layouts/admin_sidebar.php'; ?>

    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
      <h1 class="fs-2 mb-4">Panel de control</h1>
      <div class="d-flex gap-2 flex-row w-100 justify-content-between">

        <h3 class="fs-4">Productos</h3>
        <a href="/apps/theowl/public/admin/dashboard/product/create/show" class="btn btn-primary mb-3 fw-semibold">Nuevo Producto</a>
      </div>


      <div class="table-responsive">
        <table class="table table-striped table-sm">
          <thead>
            <tr>
              <th>ID</th>
              <th>Imagen</th>
              <th>Nombre</th>
              <th>Precio</th>
              <th>Acciones</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($products as $product): ?>
              <tr>
                <td><?= $product['ProductoId'] ?></td>
                <td>
                  <img src="<?= htmlspecialchars($product['Imagen']) ?>"
                    width="50" class="img-thumbnail">
                </td>
                <td><?= htmlspecialchars($product['Nombre']) ?></td>
                <td>$<?= number_format($product['Precio'], 2) ?></td>
                <td>
                  <a href="/apps/theowl/public/admin/dashboard/product/edit/show?id=<?= $product['ProductoId'] ?>" class="btn btn-sm btn-light">Editar</a>
                  <form action="/apps/theowl/public/admin/dashboard/product/delete?identifier=products&productId=<?= $product['ProductoId'] ?>" method="POST" class="d-inline">
                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Eliminar este producto?')">Eliminar</button>
                  </form>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>

      <div class="d-flex gap-2 flex-row w-100 justify-content-between">

        <h3 class="fs-4">Categorias</h3>
        <a href="/apps/theowl/public/admin/dashboard/category/create/show" class="btn btn-primary mb-3 fw-semibold">Nueva Categoria</a>
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
                  <a href="/apps/theowl/public/admin/dashboard/category/edit/show?id=<?= $category['CategoriaId'] ?>" class="btn btn-sm btn-light">Editar</a>
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