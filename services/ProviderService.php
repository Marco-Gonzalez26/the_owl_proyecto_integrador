<?php

namespace Services;

use Interfaces\ProviderRepositoryInterface;
use Interfaces\ProviderServiceInterface;
use Models\Provider;

class ProviderService implements ProviderServiceInterface
{
  private $repository;
  public function __construct(ProviderRepositoryInterface $passedRepository)
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

  public function create(Provider $data): bool
  {
    return $this->repository->create($data);
  }

  public function update(int $id, Provider $data): bool
  {
    return $this->repository->update($id, $data);
  }

  public function delete(int $id): bool
  {
    return $this->repository->delete($id);
  }
}
