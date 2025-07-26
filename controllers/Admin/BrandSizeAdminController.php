<?php

namespace Controllers\Admin;

use Interfaces\BrandSizeServiceInterface;
use Models\BrandSize;

class BrandSizeAdminController
{
  private $service;
  public function __construct(BrandSizeServiceInterface $service)
  {
    $this->service = $service;
  }


  public function createBrandWithSizes()
  {
    $brandName = $_POST['name'];
    $brandSizes = $_POST['brandSizes'] ?? [];

    if ($this->service->createBrandWithSizes($brandName, $brandSizes)) {
      echo "<script>alert('Marca y tamaños creados con éxito');
      window.location.href = '/apps/theowl/public/admin/brands';</script>";
    }
  }

  public function editBrandWithSizes()
  {
    $brandId = $_POST['brandId'];
    $brandName = $_POST['name'];
    $brandSizes = $_POST['brandSizes'] ?? [];
    // if ($this->service->updateBrandWithSizes($brandId, $brandName, $brandSizes)) {
    //   echo "<script>alert('Marca y tamaños actualizados con éxito');
    //   window.location.href = '/apps/theowl/public/admin/brands';</script>";
    // }
  }
}
