<?php

namespace App\Http\Resources;

use App\Models\ProductVariation;
use App\Models\Purchase;
use Illuminate\Http\Resources\Json\JsonResource;

class PurchaseItemsResource extends JsonResource
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
            'unit' => $this->unit_id,
            'discount' => $this->discount,
            'tax' => $this->tax,
            'subtotal' => $this->total_price,
            'purchase_price' => $this->purchase_price,
            'variation_id' => $this->product_variation_id,
            'product' => $this->product ? $this->product->name : '',
            'product_variation' => $this->productVariation ? $this->productVariation->name : '',
            'quantity' => $this->purchase_quantity,
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
