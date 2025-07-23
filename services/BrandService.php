<?php

namespace Services;

use Interfaces\BrandRepositoryInterface;
use Interfaces\BrandServiceInterface;
use Models\Brand;

class BrandService implements BrandServiceInterface
{
  private $repository;
  public function __construct(BrandRepositoryInterface $passedRepository)
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

  public function create(Brand $data): int
  {
    return $this->repository->create($data);
  }

  public function update(int $id, Brand $data): bool
  {
    return $this->repository->update($id, $data);
  }

  public function delete(int $id): bool
  {
    return $this->repository->delete($id);
  }
}
