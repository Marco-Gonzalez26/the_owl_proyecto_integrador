<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateOrderStatusRequest;
use App\Interfaces\CloudinaryServiceInterface;
use App\Interfaces\OrderItemRepositoryInterface;
use App\Interfaces\OrderRepositoryInterface;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;
use Inertia\Inertia;

class OrderController extends Controller
{
    protected $orderRepository;
    protected $orderItemRepository;

    protected $cloudinaryService;

    public function __construct(OrderRepositoryInterface $orderRepository, OrderItemRepositoryInterface $orderItemRepository, CloudinaryServiceInterface $cloudinaryService)
    {
        $this->orderRepository = $orderRepository;
        $this->orderItemRepository = $orderItemRepository;
        $this->cloudinaryService = $cloudinaryService;
    }

    public function index()
    {
        $orders = $this->orderRepository->getAll();
        return Inertia::render('orders/index', ["orders" => $orders]);
    }

    public function showEdit(int $id)
    {
        $order = $this->orderRepository->getById($id);
        return Inertia::render('orders/showEdit', ["order" => $order]);
    }

    public function update(UpdateOrderStatusRequest $request, int $id)
    {
        $order = $this->orderRepository->getById($id);
        $order->update($request->validated());
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
                "Codigo" => $order->Codigo,
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
