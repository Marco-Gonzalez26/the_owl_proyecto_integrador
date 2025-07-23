<?php
require_once __DIR__ . '/../../layouts/admin_header.php';

?>
<div class="container h-100">
  <div class="row h-100">
    <?php require_once __DIR__ . '/../../layouts/admin_sidebar.php'; ?>

    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
      <div class="d-flex gap-2 flex-row w-100 justify-content-between">

        <h3>Proveedores</h3>
        <a href="/apps/theowl/public/admin/dashboard/create?identifier=providers" class="btn btn-primary mb-3 fw-semibold">Nuevo Proveedor</a>
      </div>


      <div class="table-responsive">
        <table class="table table-striped table-sm">
          <thead>
            <tr>
              <th>ID</th>
              <th>Nombre</th>
              <th>Estado</th>
              <th>Acciones</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($providers as $provider): ?>
              <tr>
                <td><?= $provider['ProveedorId'] ?></td>
                <td><?= htmlspecialchars($provider['Nombre']) ?></td>
                <td>
                  <?php if ($provider['Estado']) echo 'Activo';
                  else echo 'Inactivo'; ?>
                </td>
                <td>
                  <a href="/apps/theowl/public/admin/dashboard/edit?identifier=providers&id=<?= $provider['ProveedorId'] ?>" class="btn btn-sm btn-light">Editar</a>
                  <form action="/apps/theowl/public/admin/dashboard/provider/delete?identifier=providers&providerId=<?= $provider['ProveedorId'] ?>" method="POST" class="d-inline">
                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Eliminar este proveedor?')">Eliminar</button>
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