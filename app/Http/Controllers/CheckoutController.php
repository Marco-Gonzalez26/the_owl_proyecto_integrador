<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Stripe\Checkout\Session;
use Stripe\Stripe;
use Stripe\StripeClient;

class CheckoutController extends Controller
{
    protected  $stripe;
    public function __construct()
    {
        // Configurar stripe
        $apiKey = env('STRIPE_SECRET_KEY');
        $this->stripe = new StripeClient(["api_key" => $apiKey]);
    }

    public function createCartCheckoutSession(Request $request)
    {

        $request->validate([
            'cart_items' => 'required|array',
            'cart_items.*.id' => 'required|array',
            'cart_items.*.quantity' => 'required|array',
            'cart_items.*.price' => 'required|array',
            'cart_items.*.name' => 'required|array',
            'cart_items.*.image' => 'required|array',

        ]);

        // Convertir productos del carrito en procuctos que stripe acepte

        $lineItems = [];
        foreach ($request->cart_items as $item) {
            $lineItems[] = [
                'price_data' => [
                    'currency' => 'usd',
                    'unit_amount' => $item->price * $item->quantity,
                    'product_data' => [
                        'name' => $item->name,
                        'images' => [$item->image],
                        'metadata' => [
                            'product_id' => $item->id,
                        ]
                    ]
                ],
                'quantity' => $item->quantity,
            ];
        }

        try {
            $session = Session::create([
                'line_items' => $lineItems,
                'mode' => 'payment',
                'success_url' => route('checkout.success') . '?session_id={CHECKOUT_SESSION_ID}',
                'cancel_url' => route('checkout.cancel'),
                "metadata" => [
                    "user_id" => $request->user()->id,
                    "cart_total_items" => count($request->cart_items)
                ]
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->withErrors($e->getMessage());
        }

        return redirect()->route('checkout.success')->with('session_id', $session->id);
    }

    public function checkOutSuccess(Request $request)
    {
        $checkOutSessionId = $request->get('session_id');

        if ($checkOutSessionId) {
            try {
                $session = Session::retrieve($checkOutSessionId, [
                    'expand' => ['line_items', 'customer_details']
                ]);

                $this->handleSuccessPayment($session);

                return Inertia::render('checkout/success', [
                    'session' => [
                        'id' => $session->id,
                        'amount_total' => $session->amount_total,
                        'currency' => $session->currency,
                        'customer_email' => $session->customer_details->email ?? null,
                        'payment_status' => $session->payment_status,
                    ]
                ]);
            } catch (\Exception $e) {
                return Inertia::render('checkout/error', [
                    "message" => 'No fue posible obtener los detalles del pago'
                ]);
            }
        }
        return Inertia::render('Checkout/Success');
    }

    public function cancelCheckOut()
    {
        return Inertia::render('checkout/cancel');
    }

    public function handleSuccessPayment($session)
    {

        // TODO: Limpiar carrito, Actualizar inventario, Crear orden
        // TODO: Enviar mensaje al whatsapp de la empresa para el envio


        $userId = $session->metadata->user_id ?? null;
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
