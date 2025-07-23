<?php

namespace Interfaces;

use Models\Provider;

interface ProviderRepositoryInterface
{
  public function getAll(): array;
  public function getById(int $id): array;
  public function create(Provider $data): bool;
  public function update(int $id, Provider $data): bool;
  public function delete(int $id): bool;
}
