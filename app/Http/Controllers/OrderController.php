<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Interfaces\OrderItemRepositoryInterface;
use App\Interfaces\OrderRepositoryInterface;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;
use Inertia\Inertia;

class OrderController extends Controller
{
    protected $orderRepository;
    protected $orderItemRepository;

    public function __construct(OrderRepositoryInterface $orderRepository, OrderItemRepositoryInterface $orderItemRepository)
    {
        $this->orderRepository = $orderRepository;
        $this->orderItemRepository = $orderItemRepository;
    }

    public function index()
    {
        return Inertia::render('order/index');
    }

    public function showUserOrders(Request $request)
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login');
        }

        $orders = $this->orderRepository->getByUserId($user->id);
        $propsOrders = $orders->map(function ($order) {
            return [
                "PedidoId" => $order->PedidoId,
                "StripeSesionId" => $order->StripeSesionId,
                "Monto" => $order->Monto,
                "Moneda" => $order->Moneda,
                "EstadoPago" => $order->EstadoPago,
                "Estado" => $order->Estado,
                "CreatedAt" => $order->CreatedAt,
                "Articulos" => $order->items->map(function ($item) {
                    return [
                        "ProductoId" => $item->ProductoId,
                        "NombreProducto" => $item->NombreProducto,
                        "PrecioUnitario" => $item->PrecioUnitario,
                        "Cantidad" => $item->Cantidad,
                        "PrecioTotal" => $item->PrecioTotal,
                        "ImagenProducto" => $item->ImagenProducto
                    ];
                })
            ];
        });
        return Inertia::render("user/orders", ["orders" => $propsOrders]);
    }
}
