<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'          => (string) $this->_id,
            'user'        => $this->whenLoaded('user', function () {
                return new UserResource($this->user);
            }),
            'order_date'  => $this->order_date,
            'status'      => $this->status,
            'order_items' => OrderItemResource::collection($this->whenLoaded('orderItems')),
        ];
    }
}
