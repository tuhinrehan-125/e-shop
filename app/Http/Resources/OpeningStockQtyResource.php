<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OpeningStockQtyResource extends JsonResource
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
            'quantity' => $this->quantity,
            'price' => $this->price,
            'business_id' => $this->business_id,
            'business_location_id' => $this->business_location_id,
            'product_id' => $this->product_id,
            'unit_id' => $this->unit_id,
            'unit_name' => $this->Unit ? $this->Unit->name : null,
        ];
    }
}
