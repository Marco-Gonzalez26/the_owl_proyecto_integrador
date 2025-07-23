<?php

namespace Services;

use Interfaces\SizeRepositoryInterface;
use Interfaces\SizeServiceInterface;
use Models\Size;

class SizeService implements SizeServiceInterface
{
  private $repository;
  public function __construct(SizeRepositoryInterface $passedRepository)
  {
    $this->repository = $passedRepository;
  }

  public function findAll(): array
  {
    return $this->repository->getAll();
  }

  public function find(int $id): array
  {
    return $this->repository->getById($id);
  }

  public function create(Size $data): bool
  {
    return $this->repository->create($data);
  }

  public function update(int $id, Size $data): bool
  {
    return $this->repository->update($id, $data);
  }

  public function delete(int $id): bool
  {
    return $this->repository->delete($id);
  }
}
