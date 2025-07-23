<?php

namespace Controllers\Admin;

use Models\Brand;
use Services\BrandService;
use Services\SizeService;

class BrandAdminController
{
  private $sizeService;
  private $brandService;
  public function __construct(BrandService $brandService, SizeService $sizeService)
  {
    $this->sizeService = $sizeService;
    $this->brandService = $brandService;
  }

  public function showBrands()
  {
    $brands = $this->brandService->findAll();
    require __DIR__ . '/../../views/admin/brands.php';
  }

  public function createBrand()
  {
    $name = $_POST['name'];
    $state = 1;
    $brand = new Brand($name, $state);

    if ($this->brandService->create($brand)) {
      echo "
      window.location.href = '/apps/theowl/public/admin/dashboard';</script>";
      exit;
    }
  }
}
