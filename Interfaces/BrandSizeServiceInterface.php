<?php

namespace Interfaces;

use Models\BrandSize;

interface BrandSizeServiceInterface
{
  public function findAll(): array;
  public function find(int $id): array;
  public function createBrandWithSizes(string $brandName, array $brandSizes): bool;
}
