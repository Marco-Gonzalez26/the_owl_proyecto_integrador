<?php

namespace App\Repositories;

use App\Interfaces\OrderRepositoryInterface;
use App\Models\Order;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Collection;

class OrderRepository implements OrderRepositoryInterface
{
    public function create(array $data): ?Order
    {
        try {
            return Order::create($data);
        } catch (\Exception $e) {
            Log::info('Error creando order en repositiorio', ['error' => $e->getMessage()]);
            return null;
        }
    }

    public function update(int $id, array $data): void
    {
        $order = Order::find($id);
        if ($order) {
            $order->update($data);
        }
    }

    public function delete(int $id): void
    {
        $order = Order::find($id);
        if ($order) {
            $order->delete();
        }
    }

    public function getById(int $id): ?Order
    {
        return Order::find($id);
    }

    public function getByUserId(int $id): Collection
    {
        return Order::where('UsuarioId', $id)->orderBy('CreatedAt', 'desc')->get();
    }
}
