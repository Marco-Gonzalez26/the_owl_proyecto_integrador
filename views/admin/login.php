<?php
require_once __DIR__ . '/../../layouts/admin_header.php';

?>

<div class="row h-100 justify-content-center align-items-center">
  <main class="col-md-8 col-lg-6 col-xl-4">
    <div class="card">
      <div class="card-body p-5">
        <div class="text-center mb-4">
          <h2 class="h4 text-gray-900 mb-3">Inicio de sesión para panel de control</h2>
        </div>

        <form action="/apps/theowl/public/admin/userLogin" method="POST">

          <label for="nombre_usuario" class="form-label">Nombre de usuario</label>
          <input name="nombre_usuario" id="nombre_usuario" required type="text"
            class="form-control form-control-lg mb-3"
            placeholder="Ingrese su usuario" />

          <label for="contrasena" class="form-label">Contraseña</label>
          <input name="contrasena" id="contrasena" required type="password"
            class="form-control form-control-lg mb-3"
            placeholder="Ingrese su contraseña" />


          <button class="btn btn-primary btn-lg" type="submit">
            Iniciar sesión
          </button>

        </form>
      </div>
    </div>
  </main>
</div>
</div>

<?php require_once __DIR__ . '/../../layouts/admin_footer.php'; ?>