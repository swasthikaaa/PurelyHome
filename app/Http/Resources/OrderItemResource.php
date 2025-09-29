<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderItemResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'       => (string) $this->_id,
            'product'  => $this->whenLoaded('product', function () {
                return new ProductResource($this->product);
            }),
            'quantity' => $this->quantity,
            'price'    => $this->price,
        ];
    }
}
