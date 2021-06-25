<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductVariationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        //$product=$this->product;
        $media=$this->product->media;
        return [
            'variation_id' => $this->id,
            'name' => $this->name,
            'sku' => $this->sub_sku,
            'product_id' => $this->product_id,
            'purchase_price' => $this->purchase_price,
            'sell_price' => $this->sell_price,
            'tax' => $this->tax,
            'image' =>$media?url('uploads/'.$media->name):url('assets/images/noimage.png'),
            'created_at' => $this->created_at ? $this->created_at->format('Y-m-d') : null
        ];
    }
}
