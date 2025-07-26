<?= require_once __DIR__ . '/../../layouts/admin_header.php'; ?>
<div class="container h-100">
  <div class="row h-100 position-relative">

    <?php require_once __DIR__ . '/../../layouts/admin_sidebar.php'; ?>

    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
      <div class="d-flex gap-2 flex-row w-100 justify-content-between">

        <h3>Marcas</h3>
        <a href="/apps/theowl/public/admin/dashboard/create?identifier=brands" class="btn btn-primary mb-3 fw-semibold">Nueva Marca</a>
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
            <?php foreach ($brands as $brand): ?>
              <tr>
                <td><?= $brand['MarcaId'] ?></td>
                <td><?= htmlspecialchars($brand['Nombre']) ?></td>
                <td>
                  <?php if ($brand['Estado']) echo 'Activo';
                  else echo 'Inactivo'; ?>
                </td>
                <td>
                  <a href="/apps/theowl/public/admin/dashboard/edit?identifier=brands&id=<?= $brand['MarcaId'] ?>" class="btn btn-sm btn-light">Editar</a>
                  <form action="/apps/theowl/public/admin/dashboard/brand/delete?identifier=brands&id=<?= $brand['MarcaId'] ?>" method="POST" class="d-inline">
                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Eliminar esta marca?')">Eliminar</button>
                  </form>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>

    </main>
  </div>
  <?= require_once __DIR__ . '/../../layouts/admin_footer.php'; ?>