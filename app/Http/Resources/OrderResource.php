<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'email' => $this->email,
            'name' => $this->name,
            'address' => $this->address,
            'totalPrice' => $this->total_price,
            'createdAt' => $this->created_at->format('Y-m-d H:i:s'),
            'items' => OrderItemResource::collection($this->items)
        ];
    }
}
