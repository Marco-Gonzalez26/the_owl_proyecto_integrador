<?php

namespace App\Interfaces;

use App\Models\Order;
use Illuminate\Database\Eloquent\Collection;

interface OrderRepositoryInterface
{
    public function create(array $data): ?Order;
    public function update(int $id, array $data): void;
    public function delete(int $id): void;

    public function getById(int $id): ?Order;

    public function getByUserId(int $id): Collection;
}
