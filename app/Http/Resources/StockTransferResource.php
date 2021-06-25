<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class StockTransferResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $data = [
            'id' => $this->id,
            'from_location' => $this->from_location,
            'to_location' => $this->to_location,
            'from_business_location' => $this->fromLocation?$this->fromLocation->name:'',
            'to_business_location' => $this->toLocation?$this->fromLocation->name:'',
            'ref_no' => $this->ref_no,
            'status' => $this->status,
            'shipping_cost' => $this->shipping_cost,
            'note' => $this->note,
            'total' => $this->total,
        ];
        if ($request->route()->parameters()) {
            $data['items'] = StockTransferItemResource::collection($this->items);
        }
        return $data;
    }
}


