<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SingleProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $purhcase_price = 0;
        $sell_price = 0;
        $tax = 0;
        $opening_stocks = [];
        $variation_id = null;

        if (count($this->variations) > 1) {
            $variations = $this->variations;
            $variation_id = $this->variations->pluck('id');
            $purhcase_price = $variations->min('purchase_price') . '-' . $variations->max('purchase_price');
            $sell_price = $variations->min('sell_price') . '-' . $variations->max('sell_price');
        } else {
            $variations = $this->variations;
            $variation_id = $this->variations->first()->id;
            foreach ($variations as $key => $value) {
                $purhcase_price = $value->purchase_price;
                $sell_price = $value->sell_price;
                $tax = $value->tax;
                break;
            }
            if ($this->openingStocks) {
                foreach ($this->openingStocks as $key => $value) {
                    $data = [
                            'id' =>  $value->id,
                            'location_id' =>  $value->business_location_id,
                            'quantity' => $value->quantity,
                            'name' => $value->location->name,
                            'address' => $value->location->name . ',' . $value->location->state . ',' . $value->location->city . ',' . $value->location->country . ',' . $value->location->zip_code
                    ];
                    array_push($opening_stocks, $data);
                }
            }
        }
        return [
            'id' => $this->id,
            'name' => $this->name,
            'image' => $this->media ? url('uploads/' . $this->media->name) : null,
            'type' => $this->type,
            'unit_id' => $this->unit_id,
            'unit_name' => $this->Unit ? $this->Unit->name : null,
            'brand' => $this->Brand ? $this->Brand->name : null,
            'category_id' => $this->category_id,
            'category' => $this->Category->name,
            'product_variation' => $this->type == 'variable' ? $this->variations : [],
            'variation_id' => $variation_id,
            'tax' => count($this->variations) > 1 ? 0 : $tax,
            'opening_stocks' => $opening_stocks,
            'add_opening_stock'=>count($opening_stocks)>0?'1':'0',
            'tax_method' => ucfirst($this->tax_type),
            'tax_type' => $this->tax_type,
            'enable_stock' => $this->enable_stock,
            'alert_quantity' => $this->alert_quantity,
            'sku' => $this->sku,
            'product_description' => $this->product_description,
            'weight' => $this->weight,
            'barcode_type' => $this->barcode_type,
            'purchase_price' => $purhcase_price,
            'sell_price' => $sell_price,
        ];
    }
}
