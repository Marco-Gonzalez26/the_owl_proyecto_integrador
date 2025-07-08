<?php

namespace Interfaces;

use Models\Product;

interface ProductRepositoryInterface
{
  public function getAll(): array;
  public function getById(int $id): array;
  public function create(Product $data): bool;
  public function update(int $id, Product $data): bool;

  public function delete(int $id): bool;
}
