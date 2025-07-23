<?php

namespace Interfaces;

use Models\Brand;

interface BrandRepositoryInterface
{
  public function getAll(): array;
  public function getById(int $id): array;
  public function create(Brand $data): int;
  public function update(int $id, Brand $data): bool;
  public function delete(int $id): bool;
}
