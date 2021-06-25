<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SalePurchaseReturnResource extends JsonResource
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
            'business_id' => $this->business_id,
            'business-name' => $this->Business ? $this->Business->name : null,
            'business_location_id' => $this->business_location_id,
            'business-location' => $this->BusinessLocation ? $this->BusinessLocation->name : null,
            'purchase_id' => $this->purchase_id,
            'sale_id' => $this->sale_id,
            'product_id' => $this->product_id,
            'product-name' => $this->Product ? $this->Product->name : null,
            'quantity' => $this->quantity,
            'amount' => $this->amount,
            'created_at' => $this->created_at->format('Y-m-d'),
        ];
    }
}
