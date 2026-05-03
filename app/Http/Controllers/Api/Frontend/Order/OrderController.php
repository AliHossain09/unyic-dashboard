<?php

namespace App\Http\Controllers\Api\Frontend\Order;

use App\Http\Controllers\Controller;
use App\Http\Resources\OrderResource;
use App\Models\Address;
use App\Models\Cart;
use App\Models\Order;
use App\Models\PaymentTransaction;
use App\Services\SslCommerzService;
use App\Support\GuestCookie;
use App\Support\ShoppingIdentity;
use App\Support\ShoppingScope;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Throwable;

class OrderController extends Controller
{
    public function checkout(Request $request, SslCommerzService $sslCommerz): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'address_id' => ['nullable', 'integer', 'exists:addresses,id'],
            'customer_name' => ['nullable', 'string', 'max:255'],
            'customer_email' => ['nullable', 'email', 'max:255'],
            'customer_phone' => ['nullable', 'string', 'max:30'],
            'customer_address' => ['nullable', 'string', 'max:1000'],
            'shipping_amount' => ['nullable', 'numeric', 'min:0'],
            'discount_amount' => ['nullable', 'numeric', 'min:0'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first(),
            ], 422);
        }

        if (! $sslCommerz->isConfigured()) {
            return response()->json([
                'success' => false,
                'message' => 'SSLCommerz credentials are not configured.',
            ], 500);
        }

        $identity = ShoppingIdentity::resolve($request);
        $cartItems = ShoppingScope::apply(
            Cart::with('product')->latest(),
            $identity
        )->get();

        if ($cartItems->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'Cart is empty.',
            ], 422);
        }

        $address = $this->resolveAddress($request, $identity);
        $customer = $this->customerPayload($request, $address);

        if (! $customer['name'] || ! $customer['email'] || ! $customer['phone'] || ! $customer['address']) {
            return response()->json([
                'success' => false,
                'message' => 'Customer name, email, phone and address are required.',
            ], 422);
        }

        try {
            $order = DB::transaction(function () use ($request, $identity, $cartItems, $address, $customer) {
                $subtotal = $cartItems->sum(fn ($item) => (float) $item->product->price * (int) $item->quantity);
                $shippingAmount = (float) $request->input('shipping_amount', 0);
                $discountAmount = (float) $request->input('discount_amount', 0);
                $totalAmount = max(0, $subtotal + $shippingAmount - $discountAmount);
                $orderNumber = 'UNYIC-'.now()->format('YmdHis').'-'.Str::upper(Str::random(5));

                $order = Order::create([
                    'order_number' => $orderNumber,
                    'user_id' => $identity['user_id'],
                    'guest_token' => $identity['guest_token'],
                    'address_id' => $address?->id,
                    'customer_name' => $customer['name'],
                    'customer_email' => $customer['email'],
                    'customer_phone' => $customer['phone'],
                    'customer_address' => $customer['address'],
                    'subtotal' => $subtotal,
                    'shipping_amount' => $shippingAmount,
                    'discount_amount' => $discountAmount,
                    'total_amount' => $totalAmount,
                    'currency' => config('sslcommerz.currency', 'BDT'),
                    'status' => 'pending',
                    'payment_status' => 'pending',
                    'payment_method' => 'sslcommerz',
                    'transaction_id' => $orderNumber,
                ]);

                foreach ($cartItems as $cartItem) {
                    $product = $cartItem->product;
                    $unitPrice = (float) $product->price;
                    $quantity = (int) $cartItem->quantity;

                    $order->items()->create([
                        'product_id' => $product->id,
                        'product_name' => $product->name,
                        'product_slug' => $product->slug,
                        'size' => $cartItem->size,
                        'quantity' => $quantity,
                        'unit_price' => $unitPrice,
                        'line_total' => $unitPrice * $quantity,
                    ]);
                }

                return $order->load('items');
            });

            $session = $sslCommerz->createSession($order, $this->callbackUrls($request));

            if (($session['status'] ?? null) !== 'SUCCESS' || empty($session['GatewayPageURL'])) {
                $order->update([
                    'payment_status' => 'failed',
                    'payment_payload' => $session,
                ]);

                return response()->json([
                    'success' => false,
                    'message' => $session['failedreason'] ?? 'Failed to create SSLCommerz payment session.',
                    'data' => new OrderResource($order),
                ], 502);
            }

            $order->update([
                'ssl_session_key' => $session['sessionkey'] ?? null,
                'payment_payload' => $session,
            ]);

            return $this->withGuestCookie($identity, response()->json([
                'success' => true,
                'message' => 'Payment session created successfully.',
                'data' => [
                    'order' => new OrderResource($order->fresh('items')),
                    'paymentUrl' => $session['GatewayPageURL'],
                    'sessionKey' => $session['sessionkey'] ?? null,
                    'gateways' => $session['gw'] ?? null,
                ],
            ]));
        } catch (Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to start checkout.',
                'errors' => [$e->getMessage()],
            ], 500);
        }
    }

    public function show(Request $request, string $orderNumber): JsonResponse
    {
        $identity = ShoppingIdentity::resolve($request);
        $query = Order::with('items')->where('order_number', $orderNumber);

        if ($identity['type'] === 'user') {
            $query->where('user_id', $identity['user_id']);
        } else {
            $query->whereNull('user_id')->where('guest_token', $identity['guest_token']);
        }

        $order = $query->first();

        if (! $order) {
            return response()->json([
                'success' => false,
                'message' => 'Order not found.',
            ], 404);
        }

        return $this->withGuestCookie($identity, response()->json([
            'success' => true,
            'data' => new OrderResource($order),
        ]));
    }

    public function success(Request $request, SslCommerzService $sslCommerz): JsonResponse|RedirectResponse
    {
        $order = $this->handleGatewayResponse($request, $sslCommerz, 'success');

        return $this->callbackResponse($request, $order, 'success');
    }

    public function fail(Request $request): JsonResponse|RedirectResponse
    {
        $order = $this->markGatewayFailed($request, 'failed');

        return $this->callbackResponse($request, $order, 'fail');
    }

    public function cancel(Request $request): JsonResponse|RedirectResponse
    {
        $order = $this->markGatewayFailed($request, 'cancelled');

        return $this->callbackResponse($request, $order, 'cancel');
    }

    public function ipn(Request $request, SslCommerzService $sslCommerz): JsonResponse
    {
        $order = $this->handleGatewayResponse($request, $sslCommerz, 'ipn');

        return response()->json([
            'success' => (bool) $order,
            'message' => $order ? 'IPN processed.' : 'Order not found.',
        ], $order ? 200 : 404);
    }

    private function handleGatewayResponse(Request $request, SslCommerzService $sslCommerz, string $source): ?Order
    {
        $order = $this->findOrderFromGatewayRequest($request);

        if (! $order) {
            return null;
        }

        $payload = $request->all();
        $validation = [];

        if ($request->filled('val_id')) {
            $validation = $sslCommerz->validatePayment((string) $request->input('val_id'));
        }

        $gatewayStatus = $validation['status'] ?? $request->input('status');
        $amountMatches = ! isset($validation['amount'])
            || abs((float) $validation['amount'] - (float) $order->total_amount) < 0.01;
        $isValid = in_array($gatewayStatus, ['VALID', 'VALIDATED'], true) && $amountMatches;
        $riskLevel = (string) ($validation['risk_level'] ?? $request->input('risk_level', '0'));

        DB::transaction(function () use ($order, $request, $payload, $validation, $gatewayStatus, $isValid, $riskLevel, $source) {
            PaymentTransaction::updateOrCreate(
                [
                    'order_id' => $order->id,
                    'tran_id' => $order->transaction_id,
                ],
                [
                    'val_id' => $request->input('val_id') ?: ($validation['val_id'] ?? null),
                    'bank_tran_id' => $validation['bank_tran_id'] ?? $request->input('bank_tran_id'),
                    'amount' => $validation['amount'] ?? $request->input('amount'),
                    'currency' => $validation['currency'] ?? $request->input('currency'),
                    'card_type' => $validation['card_type'] ?? $request->input('card_type'),
                    'card_issuer' => $validation['card_issuer'] ?? $request->input('card_issuer'),
                    'card_brand' => $validation['card_brand'] ?? $request->input('card_brand'),
                    'card_category' => $validation['card_category'] ?? $request->input('card_category'),
                    'status' => $gatewayStatus ?: 'unknown',
                    'risk_level' => $riskLevel,
                    'risk_title' => $validation['risk_title'] ?? $request->input('risk_title'),
                    'gateway_response' => [
                        'source' => $source,
                        'request' => $payload,
                        'validation' => $validation,
                    ],
                ]
            );

            if ($isValid && $riskLevel !== '1') {
                $order->update([
                    'status' => 'processing',
                    'payment_status' => 'paid',
                    'paid_at' => now(),
                    'payment_payload' => $validation ?: $payload,
                ]);

                $this->clearOrderCart($order);
            } elseif ($isValid) {
                $order->update([
                    'status' => 'on_hold',
                    'payment_status' => 'pending_review',
                    'payment_payload' => $validation ?: $payload,
                ]);
            } else {
                $order->update([
                    'payment_status' => 'failed',
                    'payment_payload' => $validation ?: $payload,
                ]);
            }
        });

        return $order->fresh('items');
    }

    private function markGatewayFailed(Request $request, string $status): ?Order
    {
        $order = $this->findOrderFromGatewayRequest($request);

        if (! $order) {
            return null;
        }

        $order->update([
            'payment_status' => $status,
            'payment_payload' => $request->all(),
        ]);

        return $order->fresh('items');
    }

    private function findOrderFromGatewayRequest(Request $request): ?Order
    {
        $transactionId = $request->input('tran_id') ?: $request->input('value_b');

        if (! $transactionId) {
            return null;
        }

        return Order::with('items')->where('transaction_id', $transactionId)->first();
    }

    private function resolveAddress(Request $request, array $identity): ?Address
    {
        $query = ShoppingScope::apply(Address::query(), $identity);

        if ($request->filled('address_id')) {
            return (clone $query)->where('id', $request->integer('address_id'))->first();
        }

        return $query->where('is_selected', true)->first();
    }

    private function customerPayload(Request $request, ?Address $address): array
    {
        return [
            'name' => $address?->name ?: $request->input('customer_name'),
            'email' => $address?->email ?: $request->input('customer_email'),
            'phone' => $address?->phone ?: $request->input('customer_phone'),
            'address' => $address?->address ?: $request->input('customer_address'),
        ];
    }

    private function callbackUrls(Request $request): array
    {
        $baseUrl = $request->getSchemeAndHttpHost();

        return [
            'success' => $baseUrl.'/api/payments/sslcommerz/success',
            'fail' => $baseUrl.'/api/payments/sslcommerz/fail',
            'cancel' => $baseUrl.'/api/payments/sslcommerz/cancel',
            'ipn' => $baseUrl.'/api/payments/sslcommerz/ipn',
        ];
    }

    private function callbackResponse(Request $request, ?Order $order, string $type): JsonResponse|RedirectResponse
    {
        $frontendUrl = config("sslcommerz.frontend_{$type}_url");

        if ($frontendUrl) {
            return redirect()->away($frontendUrl.($order ? '?order='.$order->order_number : ''));
        }

        return response()->json([
            'success' => (bool) $order,
            'message' => $order ? 'Payment callback processed.' : 'Order not found.',
            'data' => $order ? new OrderResource($order) : null,
        ], $order ? 200 : 404);
    }

    private function clearOrderCart(Order $order): void
    {
        $query = Cart::query();

        if ($order->user_id) {
            $query->where('user_id', $order->user_id);
        } else {
            $query->whereNull('user_id')->where('guest_token', $order->guest_token);
        }

        $query->delete();
    }

    private function withGuestCookie(array $identity, JsonResponse $response): JsonResponse
    {
        if ($identity['type'] === 'guest' && $identity['guest_token']) {
            $response->cookie(GuestCookie::make($identity['guest_token']));
        }

        return $response;
    }
}
