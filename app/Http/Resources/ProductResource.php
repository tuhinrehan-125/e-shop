<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
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

        if (count($this->variations) > 1) {
            $variations = $this->variations;
            $purhcase_price = $variations->min('purchase_price') . '-' . $variations->max('purchase_price');
            $sell_price = $variations->min('sell_price') . '-' . $variations->max('sell_price');
        } else {
            $variations = $this->variations;
            foreach ($variations as $key => $value) {
                $purhcase_price = $value->purchase_price;
                $sell_price = $value->sell_price;
                break;
            }
        }
        return [
            'id' => $this->id,
            'name' => $this->name,
            'image' =>$this->media?url('uploads/'.$this->media->name):url('assets/images/noimage.png'),
            'type' => $this->type,
            'unit_id' => $this->unit_id,
            'unit_name' => $this->Unit ? $this->Unit->name : null,
            'brand' => $this->Brand ? $this->Brand->name : null,
            'category' => $this->Category->name,
            'tax' => $this->tax,
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
