<?php

namespace App\Repositories;

use App\Interfaces\OrderItemRepositoryInterface;
use App\Models\OrderItem;

class OrderItemRepository implements OrderItemRepositoryInterface
{
    public function create(array $data): ?OrderItem
    {
        try {
            return OrderItem::create($data);
        } catch (\Exception $e) {
            return null;
        }
    }

    public function update(int $id, array $data): void
    {
        $orderItem = OrderItem::find($id);
        if ($orderItem) {
            $orderItem->update($data);
        }
    }

    public function delete(int $id): void
    {
        $orderItem = OrderItem::find($id);
        if ($orderItem) {
            $orderItem->delete();
        }
    }

    public function getById(int $id): ?OrderItem
    {
        return OrderItem::find($id);
    }

    public function getByOrderId(int $orderId): ?OrderItem
    {
        return OrderItem::where('PedidoId', $orderId)->first();
    }
}
