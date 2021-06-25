<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BusinessResource extends JsonResource
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
            'currency_id' => $this->currency_id,
            'time_zone' => $this->time_zone,
            'sku_prefix' => $this->sku_prefix,
            'default_unit' => $this->default_unit,
            'created_at' => $this->created_at ? $this->created_at->format('Y-m-d') : null
        ];
    }
}
