<?php

namespace Models;

use Models\Role;

class User
{
  public function __construct(
    public ?int $id,
    public string $username,
    public string $password,
    public Role $role
  ) {}
}
