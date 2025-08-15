<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'          => $this->id,
            'user'        => new UserResource($this->whenLoaded('user')),
            'order_date'  => $this->order_date,
            'status'      => $this->status,
            'order_items' => OrderItemResource::collection($this->whenLoaded('orderItems')),
            'payment'     => new PaymentResource($this->whenLoaded('payment')),
        ];
    }
}
