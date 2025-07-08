<?php

namespace Interfaces;

use Models\Category;

interface CategoryRepositoryInterface
{
  public function getAll(): array;
  public function getById(int $id): array;
  public function create(Category $data): bool;
  public function update(int $id, Category $data): bool;

  public function delete(int $id): bool;
}
