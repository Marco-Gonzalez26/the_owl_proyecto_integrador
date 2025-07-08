<?php

namespace Interfaces;

use Models\Product;

interface ProductServiceInterface
{
  public function findAll(): array;
  public function find(int $int): array;
  public function create(Product $data): bool;
  public function update(int $id, Product $data): bool;
  public function delete(int $id): bool;
}
