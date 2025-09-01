<?php

namespace Interfaces;

use Models\User;

interface UserRepositoryInterface
{
  public function getAll(): array;
  public function getById(int $id): array;

  public function getByUsername(string $username): ?User;
  public function create(User $data): bool;

  public function update(int $id, User $data): bool;

  public function delete(int $id): bool;
}
