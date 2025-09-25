<?php

namespace App\Repositories;

use App\Interfaces\MeasureUnitRepositoryInterface;
use App\Models\MeassureUnit;
use Illuminate\Database\Eloquent\Collection;

class MeasureUnitRepository implements MeasureUnitRepositoryInterface
{
    protected $model;

    public function __construct(MeassureUnit $model)
    {
        $this->model = $model;
    }

    public function getAll(): Collection
    {
        return $this->model->all();
    }

    public function getById(int $id): ?MeassureUnit
    {
        return $this->model
            ->find($id);
    }
}
