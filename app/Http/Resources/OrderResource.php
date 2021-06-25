<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'invoice_no' => $this->Order->invoice_no,
            'customer' => $this->Customer->name,
            'product' => $this->Product->name,
            'product_id' => $this->product_id,
            'quantity' => $this->quantity,
            'quantity_name' => $this->quantity_name,
            'payment_type' => $this->payment_type,
            'total_price' => $this->total,
            'created_at' => $this->created_at->format('Y-m-d'),
        ];
    }
}
