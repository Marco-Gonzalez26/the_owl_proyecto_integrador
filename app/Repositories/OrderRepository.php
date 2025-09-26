<?php

namespace App\Repositories;

use App\Interfaces\OrderRepositoryInterface;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Collection;

class OrderRepository implements OrderRepositoryInterface
{
    protected $orderModel;
    protected $orderItemModel;
    public function __construct(Order $orderModel, OrderItem $orderItemModel)
    {
        $this->orderModel = $orderModel;
        $this->orderItemModel = $orderItemModel;
    }
    public function getAll(): Collection
    {
        return $this->orderModel->get();
    }
    public function create(array $data): ?Order
    {
        try {
            return $this->orderModel->create($data);
        } catch (\Exception $e) {
            Log::info('Error creando order en repositiorio', ['error' => $e->getMessage()]);
            return null;
        }
    }

    public function update(int $id, array $data): void
    {
        $order = $this->orderModel->find($id);
        if ($order) {
            $order->update($data);
        }
    }

    public function delete(int $id): void
    {
        $order = $this->orderModel->find($id);
        if ($order) {
            $order->delete();
        }
    }

    public function getById(int $id): ?Order
    {
        return $this->orderModel->with(["user", "items"])->find($id);
    }

    public function getByUserId(int $id): Collection
    {
        return $this->orderModel->where('UsuarioId', $id)->orderBy('CreatedAt', 'desc')->get();
    }
}
