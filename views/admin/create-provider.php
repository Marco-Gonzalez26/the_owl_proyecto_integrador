<?php require_once __DIR__ . '/../../layouts/admin_header.php'; ?>

<div class="container-fluid h-full">
  <div class="row">
    <?php require_once __DIR__ . '/../../layouts/admin_sidebar.php'; ?>
    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
      <h3>Crear Proveedor</h3>


      <form action="/apps/theowl/public/admin/provider/create" method="POST" enctype="multipart/form-data">
        <div class="mb-3">
          <label for="name" class="form-label fw-bold">Nombre</label>
          <input type="text" class="form-control" id="name" name="name" required>
        </div>

        <button type="submit" class="btn btn-primary">Crear</button>
      </form>

    </main>
  </div>
</div>

<?php require_once __DIR__ . '/../../layouts/admin_footer.php'; ?>