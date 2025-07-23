<?php

namespace Models;
class Size
{
  public $description;

  public function __construct(

    string $description

  ) {
    $this->description = $description;
  }
}
