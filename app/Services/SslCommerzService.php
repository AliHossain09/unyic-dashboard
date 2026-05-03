<?php

namespace App\Services;

use App\Models\Order;
use Illuminate\Support\Facades\Http;

class SslCommerzService
{
    public function createSession(Order $order, array $urls): array
    {
        $response = Http::asForm()
            ->timeout(30)
            ->post($this->sessionUrl(), $this->sessionPayload($order, $urls))
            ->throw()
            ->json();

        return is_array($response) ? $response : [];
    }

    public function validatePayment(string $validationId): array
    {
        $response = Http::timeout(30)
            ->get($this->validationUrl(), [
                'val_id' => $validationId,
                'store_id' => config('sslcommerz.store_id'),
                'store_passwd' => config('sslcommerz.store_password'),
                'v' => 1,
                'format' => 'json',
            ])
            ->throw()
            ->json();

        return is_array($response) ? $response : [];
    }

    public function isConfigured(): bool
    {
        return filled(config('sslcommerz.store_id')) && filled(config('sslcommerz.store_password'));
    }

    private function sessionPayload(Order $order, array $urls): array
    {
        $items = $order->items;
        $firstItem = $items->first();
        $productNames = $items->pluck('product_name')->take(5)->implode(', ');

        return [
            'store_id' => config('sslcommerz.store_id'),
            'store_passwd' => config('sslcommerz.store_password'),
            'total_amount' => number_format((float) $order->total_amount, 2, '.', ''),
            'currency' => $order->currency,
            'tran_id' => $order->transaction_id,
            'success_url' => $urls['success'],
            'fail_url' => $urls['fail'],
            'cancel_url' => $urls['cancel'],
            'ipn_url' => $urls['ipn'],
            'cus_name' => $order->customer_name,
            'cus_email' => $order->customer_email,
            'cus_add1' => $order->customer_address,
            'cus_city' => 'Dhaka',
            'cus_state' => 'Dhaka',
            'cus_postcode' => '1000',
            'cus_country' => 'Bangladesh',
            'cus_phone' => $order->customer_phone,
            'shipping_method' => 'YES',
            'num_of_item' => max(1, $items->count()),
            'ship_name' => $order->customer_name,
            'ship_add1' => $order->customer_address,
            'ship_city' => 'Dhaka',
            'ship_state' => 'Dhaka',
            'ship_postcode' => '1000',
            'ship_country' => 'Bangladesh',
            'product_name' => $productNames ?: 'Order '.$order->order_number,
            'product_category' => $firstItem?->product_name ?: 'general',
            'product_profile' => 'physical-goods',
            'product_amount' => number_format((float) $order->subtotal, 2, '.', ''),
            'discount_amount' => number_format((float) $order->discount_amount, 2, '.', ''),
            'value_a' => (string) $order->id,
            'value_b' => $order->order_number,
        ];
    }

    private function sessionUrl(): string
    {
        return $this->baseUrl().'/gwprocess/v4/api.php';
    }

    private function validationUrl(): string
    {
        return $this->baseUrl().'/validator/api/validationserverAPI.php';
    }

    private function baseUrl(): string
    {
        return config('sslcommerz.sandbox')
            ? 'https://sandbox.sslcommerz.com'
            : 'https://securepay.sslcommerz.com';
    }
}
