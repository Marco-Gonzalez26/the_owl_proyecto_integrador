<?php

namespace Models;

class Sale
{

  public $clientName;
  public $clientPhone;
  public $invoiceId;
  public $total;

  public function __construct(
    string $clientName,
    string $clientPhone,
    int $invoiceId,
    int $total
  ) {
    $this->clientName = $clientName;
    $this->clientPhone = $clientPhone;
    $this->invoiceId = $invoiceId;
    $this->total = $total;
  }
}
