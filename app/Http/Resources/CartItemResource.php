<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CartItemResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $product = $this->product; // comes from accessor in CartItem model (MySQL lookup)

        return [
            'id'         => (string) $this->_id,   // MongoDB ObjectId
            'cart_id'    => $this->cart_id,
            'product_id' => $this->product_id,
            'quantity'   => $this->quantity,

            'product'    => $product ? [
                'id'          => $product->id,
                'name'        => $product->name,
                'offer_price' => $product->offer_price,
                'image_url'   => $product->image ?? $product->image_url ?? 'https://via.placeholder.com/100',
            ] : null,
        ];
    }
}
