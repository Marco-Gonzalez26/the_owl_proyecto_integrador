<button class="btn btn-dark  d-flex  align-items-center justify-content-center position-absolute top-0 start-0" id="admin-sidebar-btn">
  <i class="bi bi-list"></i>
</button>

<aside class=" pt-sm-5 col-md-3 col-lg-2  bg-light h-100  flex-column justify-content-between vh-100 position-sticky top-0 pt-5" id="admin-sidebar">
  <div class="h-100 d-flex flex-column align-items-center">
    <ul class="nav flex-column d-flex gap-2 mb-3">
      <li class="nav-item">
        <a class="nav-link" href="/apps/theowl/public/products">
          <i class="bi bi-globe"></i>
          Pagina Web
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="/apps/theowl/public/admin/dashboard">
          <i class="bi bi-box-seam"></i>
          Inventario</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="/apps/theowl/public/admin/products"> <i class="bi bi-bag"></i> Productos</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="/apps/theowl/public/admin/categories">
          <i class="bi bi-tags"></i>
          Categorías</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="/apps/theowl/public/admin/providers">
          <i class="bi bi-building"></i>
          Proveedores</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="/apps/theowl/public/admin/brands">
          <i class="bi bi-bookmarks"></i>
          Marcas</a>
      </li>
    </ul>
    <a class="btn btn-dark w-100" href="/apps/theowl/public/admin/logout">Cerrar sesión</a>
  </div>
</aside>


<style>
  .sidebar {
    position: sticky;
    top: 0;
    left: 0;
    height: 100dvh;
    padding-top: 20px;
  }

  .nav-link {
    font-weight: 500;
    color: #333;

  }

  .nav-link.active {
    color: #007bff;
  }

  .nav-link.active:hover {
    color: #0056b3;
  }

  .nav-link:hover {
    color: #0056b3;
  }

  .nav-link:hover {
    color: rgb(1, 52, 107);
  }

  #admin-sidebar-btn {
    width: 3rem;
    height: 3rem;
    z-index: 1000;
  }

  #admin-sidebar {
    display: none;
    transition: display 0.5s ease-in-out;
    border-radius: 8px;
  }

  #admin-sidebar.show-sidebar {
    display: flex;

  }
</style>