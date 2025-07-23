<?php

namespace Interfaces;

use Models\Size;

interface SizeRepositoryInterface
{
  public function getAll(): array;
  public function getById(int $id): array;
  public function create(Size $data): int;
  public function update(int $id, Size $data): bool;
  public function delete(int $id): bool;
}
