<?php

namespace Interfaces;

use Models\BrandSize;

interface BrandSizeRepositoryInterface
{
  public function getAll(): array;
  public function getByBrandId(int $brandId): array;
  public function create(BrandSize $data): bool;
}
