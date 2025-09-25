<?php

namespace App\Repositories;


use Illuminate\Database\Eloquent\Collection;
use App\Interfaces\SizeRepositoryInterface;
use App\Models\Size;
use Illuminate\Support\Facades\Log;

class SizeRepository implements SizeRepositoryInterface
{
    protected $model;
    public function __construct(Size $sizeModel)
    {
        $this->model = $sizeModel;
    }
    public function getAll(): Collection
    {
        return $this->model->with(['UnidadMedida:UnidadId,Descripcion,Abreviacion'])->get();
    }

    public function getById(int $id): Size
    {
        return $this->model->with(['UnidadMedida:UnidadId,Descripcion,Abreviacion'])->find($id);
    }

    public function create(array $data): Size
    {
        return $this->model->create($data);
    }

public function update(int $id, array $data): bool
    {
        Log::info('SizeRepository->update', ['data' => $data, "id" => $id]);
        $size = $this->model->find($id);
        if (!$size) {
            return false;
        }
        return $size->update([
            "UnidadMedida" => $data['UnidadMedida'],
            "Valor" => $data['Valor'],
            "Descripcion" => $data['Descripcion']
        ]);
    }

    public function delete(int $id): bool
    {
        return $this->model->update(["TamanoId" => $id, "Estado" => false]);
    }


    public function checkIfSizeValueExists(array $data): bool
    {
        return $this->model->where('UnidadMedida', $data['UnidadMedida'])->exists();
    }
}
