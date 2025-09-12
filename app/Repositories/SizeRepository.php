<?php

namespace Repositories;

require_once __DIR__ . '/../vendor/autoload.php';

use PDO;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Interfaces\SizeRepositoryInterface;
use App\Models\Size;

class SizeRepository implements SizeRepositoryInterface
{
    protected $model;
    public function __construct(Size $sizeModel)
    {
        $this->model = $sizeModel;
    }
    public function getAll(): Collection
    {
        return $this->model->all();
    }

    public function getById(int $id): Size
    {
        return $this->model->find($id);
    }

    public function create(array $data): Size
    {
        return $this->model->create($data);
    }

    public function update(int $id, array $data): bool
    {
        return $this->model->update(["TamanoId" => $id, "UnidadMedida" => $data['unidad_medida'], "Valor" => $data['valor'], "Descripcion" => $data['descripcion']]);
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
