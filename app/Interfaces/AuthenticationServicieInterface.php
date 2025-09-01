<?php

namespace Interfaces;

use Models\Role;

interface AuthenticationServicieInterface
{

  public function login(string $username, string $password): bool;

  public function logout(): void;

  public function isAuthenticated(): bool;
  public function getCurrentUserId(): ?int;

  public function getRole(): ?Role;
}
