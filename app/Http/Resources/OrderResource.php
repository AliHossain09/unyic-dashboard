<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'orderNumber' => $this->order_number,
            'transactionId' => $this->transaction_id,
            'status' => $this->status,
            'paymentStatus' => $this->payment_status,
            'paymentMethod' => $this->payment_method,
            'amounts' => [
                'subtotal' => (float) $this->subtotal,
                'shipping' => (float) $this->shipping_amount,
                'discount' => (float) $this->discount_amount,
                'total' => (float) $this->total_amount,
                'currency' => $this->currency,
            ],
            'customer' => [
                'name' => $this->customer_name,
                'email' => $this->customer_email,
                'phone' => $this->customer_phone,
                'address' => $this->customer_address,
            ],
            'items' => $this->whenLoaded('items', fn () => $this->items->map(fn ($item) => [
                'productId' => $item->product_id,
                'name' => $item->product_name,
                'slug' => $item->product_slug,
                'size' => $item->size,
                'quantity' => (int) $item->quantity,
                'unitPrice' => (float) $item->unit_price,
                'lineTotal' => (float) $item->line_total,
            ])->values()),
            'paidAt' => $this->paid_at?->toISOString(),
            'createdAt' => $this->created_at?->toISOString(),
        ];
    }
}
