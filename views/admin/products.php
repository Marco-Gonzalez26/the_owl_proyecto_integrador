<?php
require_once __DIR__ . '/../../layouts/admin_header.php';

?>
<div class="container-fluid h-100">
  <div class="row h-100">
    <?php require_once __DIR__ . '/../../layouts/admin_sidebar.php'; ?>

    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
      <div class="d-flex gap-2 flex-row w-100 justify-content-between">

        <h3>Productos</h3>
        <a href="/apps/theowl/public/admin/dashboard/create" class="btn btn-primary mb-3 fw-semibold">Nuevo Producto</a>
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
                  <a href="/apps/theowl/public/admin/dashboard/edit?identifier=products&id=<?= $product['ProductoId'] ?>" class="btn btn-sm btn-light">Editar</a>
                  <form action="/apps/theowl/public/admin/dashboard/product/delete?identifier=products&productId=<?= $product['ProductoId'] ?>" method="POST" class="d-inline">
                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Eliminar este producto?')">Eliminar</button>
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