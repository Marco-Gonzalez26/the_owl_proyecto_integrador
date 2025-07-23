<?php

namespace Services;

use Interfaces\BrandRepositoryInterface;
use Interfaces\BrandSizeRepositoryInterface;
use Interfaces\BrandSizeServiceInterface;
use Interfaces\SizeRepositoryInterface;


use Models\Brand;
use Models\BrandSize;
use Models\Size;

use Exception;

class BrandSizeService implements BrandSizeServiceInterface
{
  private $brandRepository;
  private $brandSizeRepository;
  private $sizeRepository;
  public function __construct(BrandRepositoryInterface $brandRepository, BrandSizeRepositoryInterface $brandSizeRepository, SizeRepositoryInterface $sizeRepository)
  {
    $this->brandRepository = $brandRepository;
    $this->brandSizeRepository = $brandSizeRepository;
    $this->sizeRepository = $sizeRepository;
  }

  public function findAll(): array
  {
    return $this->brandSizeRepository->getAll();
  }

  public function find(int $id): array
  {
    return $this->brandSizeRepository->getByBrandId($id);
  }

  public function createBrandWithSizes($brandName, $brandSizes): bool
  {
    try {

      $brandToAdd = new Brand($brandName, 1);
      $brandId = $this->brandRepository->create($brandToAdd);

      foreach ($brandSizes as $brandSize) {
        $sizeToAdd = new Size($brandSize);
        $sizeId = $this->sizeRepository->create($sizeToAdd);

        $brandSizeToAdd = new BrandSize($brandId, $sizeId);
        $this->brandSizeRepository->create($brandSizeToAdd);
      }
      return true;
    } catch (Exception $e) {
      echo $e->getMessage();
      return false;
    }
  }

  public function updateBrandWithSizes($brandId, $brandName, $brandSizes): bool
  {
    try {
      $brandToEdit = new Brand($brandName, 1);
      $this->brandRepository->update($brandId, $brandToEdit);
    } catch (Exception $e) {
      echo $e->getMessage();
      return false;
    }
  }
}
