<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class QuotationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $data=[
            'id' => $this->id,
            'business_location_id' => $this->business_location_id,
            'business_location' => $this->Location->name,
            'supplier' => $this->Supplier->name,
            'supplier_id' => $this->supplier_id,
            'customer_id' => $this->customer_id,
            'customer' => $this->Customer->name,
            'status' => ucfirst($this->status),
            'quotation_date' => $this->quotation_date,
            'subtotal_cost' => $this->subtotal_cost,
            'discount' => $this->discount,
            'tax' => $this->tax,
            'total_cost' => round($this->total_cost,2),
            'shipping_cost' => $this->shipping_cost,
            'note' => $this->note,
        ];
        if($request->route()->parameters())
        {
            $data['items']=QuotationItemResource::collection($this->items);
        }
        return $data;
    }
}

