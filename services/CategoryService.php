<?php

namespace Services;

use Interfaces\CategoryRepositoryInterface;
use Interfaces\CategoryServiceInterface;
use Models\Category;

class CategoryService implements CategoryServiceInterface
{
  private $repository;
  public function __construct(CategoryRepositoryInterface $passedRepository)
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

  public function create(Category $data): bool
  {
    return $this->repository->create($data);
  }

  public function update(int $id, Category $data): bool
  {
    return $this->repository->update($id, $data);
  }

  public function delete(int $id): bool
  {
    return $this->repository->delete($id);
  }
}
