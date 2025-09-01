<?php

namespace Interfaces;

use Models\Brand;

interface BrandServiceInterface
{
  public function findAll(): array;
  public function find(int $id): array;
  public function create(Brand $data): int;
  public function update(int $id, Brand $data): bool;
  public function delete(int $id): bool;
}
