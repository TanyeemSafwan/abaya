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
            'id' => $this->id,
            'total_price' => $this->total_price,
            'status' => $this->status,
            'phone' => $this->phone,
            'name' => $this->name,
            'city' => $this->city,
            'address_1' => $this->address_1,
            'created_at' => $this->created_at->format('Y-m-d H:i:s')
        ];
    }
}
