<?php

namespace Models;

class Role
{
  public  $name;
  public $roleId;
  public function __construct(string $name,  int $roleId)
  {
    $this->name = $name;
    $this->roleId = $roleId;
  }
}
