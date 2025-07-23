<?php require_once __DIR__ . '/../../layouts/admin_header.php'; ?>

<div class="container-fluid h-full">
  <div class="row">
    <?php require_once __DIR__ . '/../../layouts/admin_sidebar.php'; ?>

    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
      <div class="card">
        <div class="card-header bg-primary text-white w-100">Agregar Marca y Tamaños</div>
        <div class="card-body">
          <form action="/apps/theowl/public/admin/dashboard/brand/create" method="POST" id="brandForm">
            <div class="mb-3">
              <label for="name" class="form-label">Nombre de la marca</label>
              <input type="text" class="form-control" id="name" name="name" required>
            </div>

            <div id="sizesContainer">
              <label class="form-label">Tamaños</label>
              <div class="input-group mb-2">
                <input type="text" name="brandSizes[]" class="form-control" placeholder="Ejemplo: 500ml" required>
                <button type="button" class="btn btn-outline-danger remove-size"><i class="bi bi-x"></i></button>
              </div>
            </div>

            <button type="button" class="btn btn-outline-secondary mb-3" id="addSize">Agregar otro tamaño</button>

            <div>
              <button type="submit" class="btn btn-primary">Guardar Marca con Tamaños</button>
            </div>
          </form>
        </div>
      </div>
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