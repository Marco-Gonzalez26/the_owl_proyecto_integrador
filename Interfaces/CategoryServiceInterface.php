<?php

namespace Interfaces;

use Models\Category;

interface CategoryServiceInterface
{
  public function findAll(): array;
  public function find(int $int): array;
  public function create(Category $data): bool;
  public function update(int $id, Category $data): bool;
  public function delete(int $id): bool;
}
