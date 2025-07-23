<?php

namespace Interfaces;

use Models\Provider;

interface ProviderServiceInterface
{
  public function findAll(): array;
  public function find(int $id): array;
  public function create(Provider $data): bool;
  public function update(int $id, Provider $data): bool;
  public function delete(int $id): bool;
}
