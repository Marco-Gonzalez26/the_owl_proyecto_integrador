<?php

namespace Services;

use Interfaces\ProductRepositoryInterface;
use Interfaces\ProductServiceInterface;
use Models\Product;

class ProductService implements ProductServiceInterface
{
  private $repository;
  public function __construct(ProductRepositoryInterface $passedRepository)
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

  public function create(Product $data): bool
  {
    return $this->repository->create($data);
  }

  public function update(int $id, Product $data): bool
  {
    return $this->repository->update($id, $data);
  }

  public function delete(int $id): bool
  {
    return $this->repository->delete($id);
  }
}
