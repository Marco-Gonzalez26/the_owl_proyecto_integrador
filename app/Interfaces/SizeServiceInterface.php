<?php

namespace Interfaces;

use Models\Size;

interface SizeServiceInterface
{
  public function findAll(): array;
  public function find(int $id): array;
  public function create(Size $data): bool;
  public function update(int $id, Size $data): bool;
  public function delete(int $id): bool;
}
