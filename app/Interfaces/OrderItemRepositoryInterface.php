<?php

namespace App\Interfaces;

use App\Models\OrderItem;

interface OrderItemRepositoryInterface
{
    public function create(array $data): ?OrderItem;
    public function update(int $id, array $data): void;
    public function delete(int $id): void;
    public function getById(int $id): ?OrderItem;
    public function getByOrderId(int $orderId): ?OrderItem;
    
}
