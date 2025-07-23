<?php
ob_start();
?>
<h1 id="home-title">Bienvenido a The Owl</h1>
<p>Tu tienda que tiene todo lo que buscas!</p>

<style>
  #home-title {
    text-align: center;
    margin-top: 50px;
    color: #333;
  }

  p {
    text-align: center;
    font-size: 1.2em;
    color: #666;
  }
</style>

<?php
$content = ob_get_clean();
$layoutData = ['title' => 'Inicio'];
require __DIR__ . '/../Layouts/layout.php';
?>