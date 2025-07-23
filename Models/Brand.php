<?php

namespace Models;
class Brand
{
  public $name;
  public $state;

  public function __construct(

    string $name,
    int $state
  ) {
    $this->name = $name;
    $this->state = $state;
  }
}
