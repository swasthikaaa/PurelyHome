<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
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
            'category'    => new CategoryResource($this->whenLoaded('category')),
            'admin'       => new UserResource($this->whenLoaded('admin')),
            'name'        => $this->name,
            'description' => $this->description,
            'quantity'    => $this->quantity,
            'price'       => $this->price,
        ];
    }
}
