<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ContactResource extends JsonResource
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
            'supplier_business_name' => $this->supplier_business_name,
            'type' => $this->type,
            'email' => $this->email,
            'tax_number' => $this->tax_number,
            'city' => $this->city,
            'address' => $this->address,
            'state' => $this->state,
            'country' => $this->country,
            'zip_code' => $this->zip_code,
            'mobile' => $this->mobile,
            'alternate_number' => $this->alternate_number,
            'is_active' => $this->is_active,
            'customer_group_id' => $this->customer_group_id,
            'created_at' => $this->created_at->format('Y-m-d'),
        ];
    }
}
