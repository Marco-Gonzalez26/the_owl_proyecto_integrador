<?= require_once __DIR__ . '/../../layouts/admin_header.php'; ?>
<div class="container h-100">
  <div class="row">
    <?php require_once __DIR__ . '/../../layouts/admin_sidebar.php'; ?>

    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
      <h2>Editar Marca</h2>
      <?php if (isset($_GET['success'])): ?>
        <div class="alert alert-success">Marca <?= htmlspecialchars($_GET['success']) ?> correctamente</div>
      <?php endif; ?>

      <form action="/apps/theowl/public/admin/dashboard/brand/update" method="POST" enctype="multipart/form-data">
        <input hidden type="text" id="brandId" name="brandId" value="<?= htmlspecialchars($brand['MarcaId']) ?>">
        <div class="mb-3">

          <label for="name" class="form-label">Nombre de la marca</label>
          <input type="text" class="form-control" id="name" name="name" value="<?= htmlspecialchars($brand['Nombre']) ?>">
        </div>
        <div class="mb-3" id="sizesContainer">
          <label for="brandSizes" class="form-label">Tamaños</label>
          <?php foreach ($brandSizes as $brandSize): ?>
            <div class="input-group mb-2">
              <input type="text" name="brandSizes[]" class="form-control" placeholder="Ej: 500ml" required value="<?= htmlspecialchars($brandSize['DescTamano']) ?>">
              <button type="button" class="btn btn-outline-danger remove-size"><i class="bi bi-x"></i></button>
            </div>
          <?php endforeach; ?>
        </div>
        <button type="button" class="btn btn-outline-secondary mb-3" id="addSize">Agregar otro tamaño</button>
        <div>
          <button type="submit" class="btn btn-primary">Guardar Marca con Tamaños</button>
        </div>
      </form>
    </main>
  </div>
</div>


<script>
  const container = document.getElementById('sizesContainer');
  document.getElementById('addSize').addEventListener('click', () => {
    const div = document.createElement('div');
    div.className = 'input-group mb-2';
    div.innerHTML = `
      <input type="text" name="brandSizes[]" class="form-control" placeholder="Ej: 500ml" required>
      <button type="button" class="btn btn-outline-danger remove-size"><i class="bi bi-x"></i></button>
    `;
    container.appendChild(div);
  });

  container.addEventListener('click', (e) => {
    if (e.target.classList.contains('remove-size')) {
      e.target.closest('.input-group').remove();
    }
  });
</script>

<?php require_once __DIR__ . '/../../layouts/admin_footer.php'; ?>