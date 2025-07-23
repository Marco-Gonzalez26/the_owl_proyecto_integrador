<?php require_once __DIR__ . '/../../layouts/admin_header.php';


?>

<div class="container-fluid h-100">
  <div class="row">
    <?php require_once __DIR__ . '/../../layouts/admin_sidebar.php'; ?>

    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
      <h3>Crear Categoría </h3>

      <?php if (isset($_GET['success'])): ?>
        <div class="alert alert-success">Registro <?= htmlspecialchars($_GET['success']) ?> correctamente</div>
      <?php endif; ?>

      <form action="/apps/theowl/public/admin/dashboard/create/category" method="POST" enctype="multipart/form-data">
        <div class="mb-3">
          <label for="name" class="form-label">Nombre</label>
          <input type="text" class="form-control" id="name" name="nombre" required>
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