<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CustomerResource extends JsonResource
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
            'name' => $this->name,
            'address' => $this->address,
            'mobile_no' => $this->mobile_no,
            'alt_mobile_no' => $this->alt_mobile_no,
            'shop_name' => $this->shop_name,
            'shop_address' => $this->shop_address,
            'nid_no' => $this->nid_no,
            'nid_image' => $this->nid_image?asset('images/' . $this->nid_image):null,
            'customer_img' => $this->customer_img?$this->customer_img:null,
            'introducer_name' => $this->introducer_name,
            'intro_mobile_no' => $this->intro_mobile_no,
            'commission' => $this->commission,
            'created_at' => $this->created_at->format('Y-m-d'),
        ];
    }
}
