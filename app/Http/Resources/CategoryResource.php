<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
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
            'short_code' => $this->short_code,
            'business_id' => $this->business_id,
            'parent_id' => $this->parent_id,
            'parent_cat_name' => $this->Parent?$this->Parent->name:'N/A',
        ];
    }
}
