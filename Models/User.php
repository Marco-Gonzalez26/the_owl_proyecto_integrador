<?php

namespace Models;

use Models\Role;

class User
{
  public  $id;
  public  $username;
  public  $password;
  public $role;
  public function __construct(
    ?int $id,
    string $username,
    string $password,
    Role $role
  ) {
    $this->id = $id;
    $this->username = $username;
    $this->password = $password;
    $this->role = $role;
  }
}
