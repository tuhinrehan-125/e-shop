<?php

namespace App\Http\Resources;

use App\Models\Sell;
use Illuminate\Http\Resources\Json\JsonResource;

class SellItemsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $sell_returned=0;
        $sell = Sell::find($this->sell_id);
        $sell_returned=$sell->return->where('variation_id', $this->variation_id)->sum('return_quantity');

        return [
            'id' => $this->id,
            'product_id' => $this->product_id,
            'variation_id' => $this->variation_id,
            'product' => $this->productVariation ? $this->productVariation->name : '',
            'sell_price' => $this->product->tax_type=='inclusive'?$this->productVariation->sell_price:$this->productVariation->sell_price+($this->productVariation->sell_price * $this->productVariation->tax)/100,
            'unit_price' => $this->product->tax_type=='inclusive'?$this->productVariation->sell_price:$this->productVariation->sell_price+($this->productVariation->sell_price * $this->productVariation->tax)/100,
            'sell_quantity' => $this->sell_quantity,
            'subtotal'=>$this->total_price,
            'discount'=>$this->discount,
            'unit'=>$this->unit_id,
            'tax'=>$this->productVariation->tax,
            'original_tax'=>$this->productVariation->tax,
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
