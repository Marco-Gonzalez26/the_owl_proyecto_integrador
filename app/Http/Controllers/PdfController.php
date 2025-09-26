<?php

namespace App\Http\Controllers;

use App\Interfaces\CloudinaryServiceInterface;
use App\Interfaces\OrderRepositoryInterface;
use Barryvdh\DomPDF\Facade\Pdf;


class PdfController extends Controller
{
    protected $orderRepository;
    protected $cloudinaryService;
    public function __construct(OrderRepositoryInterface $orderRepository, CloudinaryServiceInterface $cloudinaryService)
    {
        $this->orderRepository = $orderRepository;
        $this->cloudinaryService = $cloudinaryService;
    }

    public function generateAndUploadPdf($order, $customer)
    {
        $pdf = Pdf::loadView('orders.pdf', compact('order', 'customer'));

        // Guardar temporalmente en storage
        $tempPath = storage_path('app/public/pedidos/pedido_' . $order['PedidoId'] . '.pdf');
        $pdf->save($tempPath);

        // Subir a Cloudinary usando tu servicio
        $cloudUrl = $this->cloudinaryService->uploadFile($tempPath, [
            'folder' => 'pedidos'
        ], 'raw');

        return $cloudUrl;
    }
}
