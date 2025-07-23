<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= $title ?? 'The Owl' ?></title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>

  <style>
    #cart-wrapper {

      width: 40%;
      top: 60px;
      transform: translateX(150%);
      transition: transform 0.5s ease-in-out;
      height: 90dvh;
      padding: 1rem;
      border-radius: 1rem;
    }

    #cart-wrapper.show {
      transform: translateX(-20px);

    }

    .product-card {
      background-color: white;
      border-radius: 1rem;
      width: 100%;
    }

    .quantity-input {
      width: 60px;
      text-align: center;
      border: 1px solid #dee2e6;
      border-radius: 6px;
    }

    .product-image {
      width: 100px;
      height: 100 px;
      object-fit: scale-down;
      border-radius: 8px;
    }

    .remove-btn {
      color: #dc2626;
      cursor: pointer;
      transition: all 0.2s;
    }

    .remove-btn:hover {
      color: #991b1b;
    }

    .quantity-btn {
      width: 28px;
      height: 28px;
      padding: 2px 4px;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      border-radius: 9000px;
      background: #f3f4f6;
      border: none;
      transition: all 0.2s;

    }

    .quantity-btn:hover {
      background: #e5e7eb;
    }

    .total {
      font-weight: bold;
      color: #2563eb;
      margin-top: 1rem;
    }

    header {
      background-color: #333;
      color: white;
      padding: 1rem;
      display: flex;
      align-items: center;
      justify-content: space-between;
      height: 50px;
    }

    header h1 {
      margin-right: 1rem;
      font-size: 1.5rem;
    }

    nav {
      display: flex;
      align-items: center;
    }

    nav ul {
      list-style-type: none;
      margin: 0;
      padding: 0;
    }

    nav ul li {
      display: inline;
      margin-right: 15px;
    }

    nav ul li a {
      color: white;
      text-decoration: none;
    }

    @media (width <=768px) {
      #cart-wrapper {
        width: 100%;
        height: 100%;
      }
    }
  </style>
</head>

<body>

  <header class="bg-dark d-flex w-100 justify-content-between sticky-top">
    <h1>The Owl 🦉</h1>
    <nav>
      <ul>
        <li><a href="/apps/theowl/public" class="link-light">Inicio</a></li>
        <li><a href="/apps/theowl/public/products" class="link-light">Productos</a></li>
      </ul>
    </nav>
    <div class="relative ">
      <button class="btn btn-secondary" id="cart-btn">
        <i class="bi bi-cart"></i>
      </button>

    </div>
  </header>
  </nav>
  <div class="container  position-relative ">
    <div class="position-fixed end-0 bg-white   p-4   z-3 overflow-y-auto shadow " id="cart-wrapper">
      <div class=" w-100  h-100">
        <div class="col-lg-8 w-100 p-4 h-100 p-2 position-relative d-flex justify-content-space-between flex-column align-items-center">
          <button class="btn btn-primary mb-2 position-absolute  top-0 end-0" onclick="cleanCart()">
            <i class="bi bi-clearfix"></i>
            Limpiar Carrito
          </button>

          <div class="d-flex  mb-4 flex-column ">
            <h4 class="mb-0">Carrito de compras</h4>
            <span class="text-muted" id="items-qty"></span>
          </div>
          <div class="d-flex flex-column gap-3 z-3" id="cart-items-container">


          </div>
          <div class="">
            <span class="d-block" id="cart-total"></span>
            <button class="btn btn-success mb-2" id="buy-btn">
              <i class="bi bi-cart"></i> Completar compra</button>
          </div>
        </div>

      </div>
    </div>