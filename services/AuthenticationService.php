<?php

namespace Services;

use Interfaces\AuthenticationServicieInterface;
use Interfaces\UserRepositoryInterface;

use Models\Role;

class AuthenticationService implements AuthenticationServicieInterface
{
  private $userRepository;
  public function __construct(UserRepositoryInterface $userRepository)
  {
    $this->userRepository = $userRepository;
  }

  public function login(string $username, string $password): bool
  {
    $user = $this->userRepository->getByUsername($username);

    if ($user && password_verify($password, $user->password)) {
      $_SESSION['user'] = $user;
      return true;
    }
    return false;
  }

  public function logout(): void
  {
    unset($_SESSION['user']);
  }

  public function isAuthenticated(): bool
  {
    return isset($_SESSION['user']);
  }

  public function getCurrentUserId(): ?int
  {
    return $_SESSION['user']->id;
  }

  public function getRole(): ?Role
  {
    return $_SESSION["user"]->role ?? null;
  }
}
