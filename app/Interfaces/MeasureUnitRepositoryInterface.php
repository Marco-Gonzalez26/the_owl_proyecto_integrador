<?php

namespace App\Interfaces;

use App\Models\MeassureUnit;
use Illuminate\Support\Collection;

interface MeasureUnitRepositoryInterface
{
    public function getAll(): Collection;
    public function getById(int $id): ?MeassureUnit;
}
