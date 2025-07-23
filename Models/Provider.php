<?php

namespace Models;

class Provider
{
  public $name;

  public  $state;

  public function __construct(
    string $name,
    string $state
  ) {
    $this->name = $name;
    $this->state = $state;
  }
}
