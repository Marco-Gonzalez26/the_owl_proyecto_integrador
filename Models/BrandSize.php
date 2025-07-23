<?php

namespace Models;

class BrandSize
{

  public $brandId;
  public $sizeId;


  public function __construct(

    int $brandId,
    int $sizeId

  ) {
    $this->brandId = $brandId;
    $this->sizeId = $sizeId;
  }
}
