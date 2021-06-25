<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SellPurchaseReturnResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return[
            'business_id'=> $this->business_id,
            'business_location_id'=> $this->business_location_id,
            'id'=> $this->id,
            'product'=> $this->product->name,
            'product_variation'=> $this->productVariation->name,
            'return_quantity'=> $this->return_quantity,
            'total_amount'=> $this->total_amount,
        ];
    }
}
