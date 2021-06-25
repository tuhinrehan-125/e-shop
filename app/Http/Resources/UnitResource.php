<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UnitResource extends JsonResource
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
            'short_name' => $this->short_name,
            'parent_id' => $this->Parent?$this->parent_id:'',
            'parent_cat_name' => $this->Parent?$this->Parent->name:'N/A',
            'value' => $this->value,
            'created_at' => $this->created_at ? $this->created_at->format('Y-m-d') : null,
        ];
    }

}
