<?php

namespace Controllers;

use Exception;

use Models\Product;

class HomeController
{
  public function index()
  {
    require_once __DIR__ . '/../views/home.php';
  }
}
