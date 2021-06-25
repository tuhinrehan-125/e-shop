<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class QuotationItemResource extends JsonResource
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
            'product_id' => $this->product_id,
            'variation_id' => $this->variation_id,
            'product' => $this->product->name,
            'quantity' => $this->quantity,
            'purchase_price' => $this->unit_price,
            'discount' => $this->discount,
            'tax' => $this->tax,
            'original_tax'=>$this->productVariation->tax,
            'unit' => $this->unit_id,
            'subtotal' => $this->total_price,
            'allunit' => $this->unit->subUnits ? $this->unit->subUnits->map(function ($value, $key) {
                $sub_units = [];
                if ($value->parent) {
                    $sub_units[] = [
                        'id' => $value->parent->id,
                        'name' => $value->parent->name,
                        'value' => $value->parent->value
                    ];
                }
                $sub_units[] = [
                    'id' => $value->id,
                    'name' => $value->name,
                    'value' => $value->value
                ];
                return $sub_units;
            })->first() : [],
        ];
    }
}
