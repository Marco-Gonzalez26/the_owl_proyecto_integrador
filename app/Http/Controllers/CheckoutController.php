<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Interfaces\CloudinaryServiceInterface;
use App\Interfaces\OrderItemRepositoryInterface;
use App\Interfaces\OrderRepositoryInterface;
use App\Interfaces\ProductRepositoryInterface;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use Stripe\Checkout\Session;
use Stripe\Stripe;
use Stripe\StripeClient;
use Illuminate\Support\Facades\Log;

class CheckoutController extends Controller
{
    protected $stripe;
    protected $orderRepository;
    protected $orderItemRepository;
    protected $productRepository;

    protected $cloudinaryService;

    public function __construct(StripeClient $stripe, OrderRepositoryInterface $orderRepository, OrderItemRepositoryInterface $orderItemRepository, ProductRepositoryInterface $productRepository, CloudinaryServiceInterface $cloudinaryService)
    {
        $this->stripe = $stripe;
        $this->orderRepository = $orderRepository;
        $this->orderItemRepository = $orderItemRepository;
        $this->productRepository = $productRepository;
        $this->cloudinaryService = $cloudinaryService;
    }

    public function createCartCheckoutSession(Request $request)
    {
        $stripe = new StripeClient(["api_key" => env('STRIPE_SECRET')]);

        Log::info('Request completa:', $request->all());

        // O solo los datos específicos que necesitas
        Log::info('Cart items:', ['cart_items' => $request->input('cart_items')]);

        // Ver headers si los necesitas
        Log::info('Headers:', $request->headers->all());
        $request->validate([
            'cart_items' => 'required|array|min:1',
            'cart_items.*.id' => 'required|integer',
            'cart_items.*.quantity' => 'required|integer|min:1',
            'cart_items.*.price' => 'required|numeric|min:0',
            'cart_items.*.name' => 'required|string',
            'cart_items.*.image' => 'required|string',
        ]);

        // Convertir productos del carrito en procuctos que stripe acepte

        $lineItems = [];
        $totalAmount = 0;
        foreach ($request->cart_items as $item) {
            $unitPrice = floatval($item['price']);
            $unitAmountCents = (int)($unitPrice * 100);
            $itemTotal = $unitAmountCents * $item['quantity'];
            $totalAmount += $itemTotal;

            $lineItems[] = [
                'price_data' => [
                    'currency' => 'usd',
                    'unit_amount' => $unitAmountCents,
                    'product_data' => [
                        'name' => $item['name'],
                        'images' => [$item['image']],
                        'metadata' => [
                            "id" => $item['id'],
                            'product_id' => $item['id'],
                        ]
                    ]
                ],
                'quantity' => (int)$item['quantity'],
            ];
        }

        try {
            $checkoutSession = $this->stripe->checkout->sessions->create([
                "locale" => "es-419",
                "customer_email" => $request->user()->email ?? $request->user()->correo,

                'line_items' =>  $lineItems,
                'mode' => 'payment',
                'success_url' => route('checkout.success') . '?session_id={CHECKOUT_SESSION_ID}',
                'cancel_url' => route('checkout.cancel'),
                "metadata" => [
                    "user_id" => $request->user()->id,
                    "cart_total_items" => count($request->cart_items),

                ]
            ]);
            return Inertia::location($checkoutSession->url);
        } catch (\Exception $e) {
            return redirect()->back()->withErrors($e->getMessage());
        }
    }

    public function checkOutSuccess(Request $request)
    {

        $checkOutSessionId = $request->get('session_id');

        if ($checkOutSessionId) {
            try {
                $session = $this->stripe->checkout->sessions->retrieve($checkOutSessionId, [
                    'expand' => ['line_items', 'customer_details', 'line_items.data.price.product',]
                ]);

                $this->handleSuccessPayment($session);

                return Inertia::render('checkout/success', [
                    'session' => [
                        'id' => $session->id,
                        'amount_total' => $session->amount_total,
                        'currency' => $session->currency,
                        'customer_email' => $session->customer_details->email ?? null,
                        'payment_status' => $session->payment_status,
                        'payment_method' => $session->payment_method,
                        "line_items" => $session->line_items
                    ]
                ]);
            } catch (\Exception $e) {
                return Inertia::render('checkout/error', [
                    "message" => 'No fue posible obtener los detalles del pago'
                ]);
            }
        }
        return Inertia::render('checkout/success');
    }

    public function cancelCheckOut()
    {
        return Inertia::render('checkout/cancel');
    }

    public function error(Request $request)
    {
        $checkOutSessionId = $request->get('session_id');

        if ($checkOutSessionId) {
            try {
                $session = $this->stripe->checkout->sessions->retrieve($checkOutSessionId, [
                    'expand' => ['line_items', 'customer_details', 'line_items.data.price.product',]
                ]);
                return Inertia::render('checkout/error', [
                    "message" => 'No fue posible obtener los detalles del pago',
                    "session" => $session
                ]);
            } catch (\Exception $e) {
                return Inertia::render('checkout/error', [
                    "message" => 'No fue posible obtener los detalles del pago'
                ]);
            }
        }
    }

    public function handleSuccessPayment($session)
    {


        $order = null;
        $user = Auth::check() ? Auth::user() : null;
        try {
            $order = $this->orderRepository->create([
                'StripeSesionId' => $session->id,
                'CorreoCliente' => $session->customer_details->email,
                'NombreCliente' => $session->customer_details->name,
                'Monto' => $session->amount_total / 100,
                'Moneda' => $session->currency,
                'EstadoPago' => $session->payment_status === 'paid' ? 'pagado' : 'pendiente',
                'Estado' => 'preparando',
                'UsuarioId' =>  $user->id,
                "DireccionFacturacion" => $user->direccion,
                "DireccionEnvio" => $user->direccion,

            ]);
            // Log::info("Creando Comprobante");
            // Log::info("Información", ["order" => $order]);
            // try {

            //     $pdf = Pdf::loadView('orders.pdf', [
            //         'order' => $order
            //     ]);
            //     $tempPath = storage_path('app/public/pedidos/pedido_' . $order->PedidoId . '.pdf');
            //     $pdf->save($tempPath);
            //     $cloudUrl = $this->cloudinaryService->uploadFile($tempPath, ['folder' => 'pedidos'], 'raw');
            //     Log::info('Order creado', ["cloud_url" => $cloudUrl]);

            //     $order->Comprobante = $cloudUrl;

            //     $order->save();
            //     Log::info("Comprobante creado");
            // } catch (\Exception $e) {
            //     Log::info("Error creando comprobante", ["error" => $e->getMessage()]);
            // }



            // Log::info('Order creado', ['order' => $order]);
            // return response()->json([
            //     'order' => $order,
            //     'pdf_url' => $cloudUrl
            // ]);
        } catch (\Exception $e) {
            Log::info('Error creando order', ['error' => $e->getMessage()]);
            return redirect()->back()->withErrors($e->getMessage());
        }

        foreach ($session->line_items as $item) {
            try {

                $productId = $item->price->product->metadata["product_id"];
                $orderItem = $this->orderItemRepository->create([
                    'PedidoId' => $order->PedidoId,
                    'ProductoId' => $productId,
                    'NombreProducto' => $item->price->product->name,
                    'PrecioUnitario' => $item->price->unit_amount / 100,
                    'Cantidad' => $item->quantity,
                    'PrecioTotal' => $item->amount_total / 100,
                    'ImagenProducto' => $item->price->product->images[0]
                ]);

                $this->productRepository->decrementStock($productId, $item->quantity);
                Log::info('Producto del pedido creado', ['producto' => $productId, 'cantidad' => $item->quantity]);
            } catch (\Exception $e) {
                Log::info('Error creando producto del pedido', ['error' => $e->getMessage()]);
            }
        }
    }

    public function testCheckout(Request $request)
    {
        $stripe = new StripeClient(["api_key" => env('STRIPE_SECRET')]);
        // Sample test data - you can modify this for different test scenarios
        $testCartItems = [
            [
                'id' => 'test-1',
                'name' => 'Test Product 1',
                'description' => 'This is a test product for Stripe integration',
                'price' => 10.00,
                'quantity' => 2,
            ],
            [
                'id' => 'test-2',
                'name' => 'Test Product 2',
                'description' => 'Another test product',
                'price' => 25.50,
                'quantity' => 1,
            ],
        ];

        // Convert to Stripe line items
        $lineItems = [];
        foreach ($testCartItems as $item) {
            $lineItems[] = [
                'price_data' => [
                    'currency' => 'usd',
                    'product_data' => [
                        'name' => $item['name'],
                        'description' => $item['description'] ?? '',
                        'metadata' => [
                            'product_id' => $item['id']
                        ]
                    ],
                    'unit_amount' => round($item['price'] * 100), // Convert to cents
                ],
                'quantity' => $item['quantity'],
            ];
        }

        try {
            $successUrl  = route('checkout.success') . '?session_id={CHECKOUT_SESSION_ID}';
            $checkoutSession = $stripe->checkout->sessions->create([
                "locale" => "es-419",
                'line_items' =>  $lineItems,
                'mode' => 'payment',
                'success_url' => route('checkout.success') . '?session_id={CHECKOUT_SESSION_ID}',
                'cancel_url' => route('checkout.cancel'),
            ]);

            return Inertia::location($checkoutSession->url);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'Failed to create test checkout session: ' . $e->getMessage(),
                'stripe_error' => $e->getCode() ?? 'unknown'
            ], 500);
        }
    }
}
